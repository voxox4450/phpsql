<?php
// Połączenie z bazą danych
include('../settings.php');
session_start();
// Obsługa rejestracji
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sprawdzenie, czy użytkownik o podanej nazwie już istnieje
    $check_user_sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($check_user_sql);

    if ($stmt === false) {
        die('Error: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $check_user_result = $stmt->get_result();

    if ($check_user_result === false) {
        // Błąd zapytania SQL
        echo "Błąd zapytania SQL: " . $stmt->error;
    } elseif ($check_user_result->num_rows > 0) {
        // Użytkownik o tej nazwie już istnieje
        $error_message = "Użytkownik o podanej nazwie już istnieje.";
    } else {
        // Prosta walidacja hasła (przynajmniej 8 znaków)
        if (strlen($password) < 8) {
            $error_message = "Hasło musi mieć co najmniej 8 znaków.";
        } else {
            // Haszowanie hasła przed zapisaniem do bazy danych
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Dodanie nowego użytkownika do bazy danych (parametryzowane zapytanie)
            $insert_user_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($insert_user_sql);

            if ($stmt === false) {
                die('Error: ' . htmlspecialchars($conn->error));
            }

            $stmt->bind_param("ss", $username, $hashed_password);
            
            if ($stmt->execute()) {
                // Pomyślna rejestracja, przekieruj na stronę logowania
                header("Location:/phpsql/pages/login.php");
                exit;
            } else {
                // Błąd rejestracji
                $error_message = "Błąd rejestracji: " . $stmt->error;
            }
        }
    }

    $stmt->close();
}

$conn->close();
?>
