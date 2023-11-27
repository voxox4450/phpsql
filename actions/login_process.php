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

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        // Użytkownik zalogowany, przekieruj na stronę główną
        session_start();
        $_SESSION['username'] = $username;  // Ustawienie danych sesji
        header("Location: /phpsql/pages/profile.php");
    } else {
        // Błąd logowania
        echo "Błędna nazwa użytkownika lub hasło.";
    }
}

$conn->close();
?>
