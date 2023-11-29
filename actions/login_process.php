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
            $_SESSION['success_message'] = "Zalogowano pomyślnie!";
            header("Location: /phpsql/pages/profile.php");
            exit; // Zakończ po przekierowaniu
        } else {
            // Błąd logowania - ustaw komunikat o błędzie w sesji
            $_SESSION['error_message'] = "Błędna nazwa użytkownika lub hasło.";
            header("Location: /phpsql/pages/login.php");
            exit;
        }
    } else {
        // Błąd logowania - ustaw komunikat o błędzie w sesji
        $_SESSION['error_message'] = "Błędna nazwa użytkownika lub hasło.";
        header("Location: /phpsql/pages/login.php");
        exit;
    }

    $stmt->close(); // Zamknięcie prepared statement
}

$conn->close();
?>
