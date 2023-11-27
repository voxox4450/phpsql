<?php
// search_courses_process.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_courses";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obsługa wyszukiwania kursów
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['query'])) {
    $query = $_GET['query'];

    // Tutaj dodaj kod do wyszukiwania kursów na podstawie zapytania
    // np. SELECT * FROM courses WHERE title LIKE '%$query%' OR description LIKE '%$query%' OR instructor LIKE '%$query%';

    // Wyświetl wyniki wyszukiwania
    // ...

    // Jeśli nie znaleziono kursów, możesz wyświetlić odpowiedni komunikat
    // ...
}

$conn->close();
?>
