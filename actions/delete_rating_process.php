<?php
// delete_rating_process.php
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

// Obsługa usuwania oceny
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating_id']) && isset($_POST['course_id'])) {
    $rating_id = $_POST['rating_id'];

    // Tutaj dodaj kod do usuwania oceny z bazy danych
    // np. DELETE FROM ratings WHERE id=$rating_id;

    // Pomyślne usunięcie oceny, przekieruj na stronę z zarządzaniem kursami
    header("Location: manage_courses.php");
}

$conn->close();
?>
