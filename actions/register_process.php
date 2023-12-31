<?php
// Połączenie z bazą danych
include('../settings.php');

// Inicjalizacja sesji
session_start();

// Funkcja do walidacji danych
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Obsługa rejestracji
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    // Sprawdzenie, czy użytkownik o podanej nazwie już istnieje
    $check_user_sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($check_user_sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $check_user_result = $stmt->get_result();

    if ($check_user_result === false) {
        // Błąd zapytania SQL
        $_SESSION['registration_message'] = "Błąd zapytania SQL: " . $conn->error;
    } elseif ($check_user_result->num_rows > 0) {
        // Użytkownik o tej nazwie już istnieje
        $_SESSION['registration_message'] = "Użytkownik o podanej nazwie już istnieje.";
    } else {
        // Prosta walidacja hasła (przynajmniej 8 znaków)
        if (strlen($password) < 8) {
            $_SESSION['registration_message'] = "Hasło musi mieć co najmniej 8 znaków.";
        } else {
            // Dodatkowa walidacja dla nazwy użytkownika
            if (strlen($username) < 5) {
                $_SESSION['registration_message'] = "Nazwa użytkownika musi mieć co najmniej 5 znaków.";
            } else {
                // Dodatkowa walidacja hasła
                if (!preg_match('/[A-Z]/', $password) ||    // Duża litera
                    !preg_match('/[a-z]/', $password) ||    // Mała litera
                    !preg_match('/\d/', $password) ||        // Cyfra
                    !preg_match('/[^A-Za-z0-9]/', $password) // Znak specjalny
                ) {
                    $_SESSION['registration_message'] = "Hasło musi zawierać co najmniej jedną dużą literę, jedną małą literę, jedną cyfrę i jeden znak specjalny.";
                } else {
                    // Haszowanie hasła przed zapisaniem do bazy danych
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Dodanie nowego użytkownika do bazy danych (parametryzowane zapytanie)
                    $insert_user_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                    $stmt = $conn->prepare($insert_user_sql);
                    $stmt->bind_param("ss", $username, $hashed_password);

                    if ($stmt->execute()) {
                        // Pomyślna rejestracja, przekieruj na stronę logowania
                        $_SESSION['registration_message'] = "Pomyślna rejestracja. Możesz się teraz zalogować.";
                        header("Location:/phpsql/pages/login.php");
                        exit; // Dodaj exit po przekierowaniu
                    } else {
                        // Błąd rejestracji
                        $_SESSION['registration_message'] = "Błąd rejestracji: " . $conn->error;
                    }
                }
            }
        }
    }

    $stmt->close(); // Zamknięcie prepared statement
    // Przekieruj z powrotem na stronę logowania
    header("Location: /phpsql/pages/register.php");
    exit;
}

$conn->close();
?>
