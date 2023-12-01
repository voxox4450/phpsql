<?php
// Połączenie z bazą danych
include('../settings.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inicjalizacja sesji
session_start();

// Obsługa logowania
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Zabezpieczenie przed SQL Injection
    $sql = "SELECT id, username, password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        $hashed_password = $userData['password'];

        // Porównanie hasła za pomocą password_verify
        if (password_verify($password, $hashed_password)) {
            // Użytkownik zalogowany, przekieruj na stronę główną
            $_SESSION['user_id'] = $userData['id'];  // Przechowaj ID użytkownika w sesji
            $_SESSION['username'] = $userData['username'];  // Ustawienie danych sesji
            $_SESSION['role'] = $userData['role']; // Dodanie informacji o roli
            $_SESSION['success_message'] = "Zalogowano pomyślnie!";
             // Przekierowanie w zależności od roli
             // Sprawdzenie, czy użytkownik jest zalogowany
            if (!isset($_SESSION['username'])) {
                header("Location: login.php");
                exit;
            }

            // Dodaj poniższe linie i sprawdź, czy poprawnie odczytujesz rolę
            echo "Rola użytkownika: " . $_SESSION['role'];

             if ($_SESSION['role'] == 'admin') {
                header("Location: /phpsql/pages/admin_panel.php");
            } else {
                header("Location: /phpsql/pages/user_panel.php");
            }
            exit; // Zakończ po przekierowaniu
        } else {
            // Błąd logowania - ustaw komunikat o błędzie w sesji
            $_SESSION['error_message'] = "Błędna nazwa użytkownika lub hasło.";
        }
    } else {
        // Błąd logowania - ustaw komunikat o błędzie w sesji
        $_SESSION['error_message'] = "Błędna nazwa użytkownika lub hasło.";
    }

    $stmt->close(); // Zamknięcie prepared statement

    // Przekieruj z powrotem na stronę logowania
    header("Location: /phpsql/pages/login.php");
    exit;
}

$conn->close();
?>
