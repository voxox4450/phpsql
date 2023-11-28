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

    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Użytkownik zalogowany, przekieruj na stronę główną
        session_start();
        $userData = $result->fetch_assoc();
        $_SESSION['user_id'] = $userData['id'];  // Przechowaj ID użytkownika w sesji
        $_SESSION['username'] = $userData['username'];  // Ustawienie danych sesji
        header("Location: /phpsql/pages/profile.php");
    } else {
        // Błąd logowania
        echo "Błędna nazwa użytkownika lub hasło.";
    }
}

$conn->close();
?>
