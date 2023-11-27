<?php
// Połączenie z bazą danych
include('../settings.php');

// Obsługa rejestracji
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sprawdzenie, czy użytkownik o podanej nazwie już istnieje
    $check_user_sql = "SELECT * FROM users WHERE username='$username'";
    $check_user_result = $conn->query($check_user_sql);

    if ($check_user_result === false) {
        // Błąd zapytania SQL
        echo "Błąd zapytania SQL: " . $conn->error;
    } elseif ($check_user_result->num_rows > 0) {
        // Użytkownik o tej nazwie już istnieje
        echo "Użytkownik o podanej nazwie już istnieje.";
    } else {
        // Dodanie nowego użytkownika do bazy danych
        $insert_user_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        
        if ($conn->query($insert_user_sql) === TRUE) {
            // Pomyślna rejestracja, przekieruj na stronę logowania
            header("Location:/phpsql/pages/login.php");
        } else {
            // Błąd rejestracji
            echo "Błąd rejestracji: " . $conn->error;
        }
    }
}

$conn->close();
?>
