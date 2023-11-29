<?php
// Połączenie z bazą danych
include('../settings.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
            session_start();
            $_SESSION['user_id'] = $userData['id'];  // Przechowaj ID użytkownika w sesji
            $_SESSION['username'] = $userData['username'];  // Ustawienie danych sesji
            header("Location: /phpsql/pages/profile.php");
            exit; // Zakończ po przekierowaniu
        } else {
            // Błąd logowania
            echo "Błędna nazwa użytkownika lub hasło.";
        }
    } else {
        // Błąd logowania
        echo "Błędna nazwa użytkownika lub hasło.";
    }

    $stmt->close(); // Zamknięcie prepared statement
}

$conn->close();
?>
