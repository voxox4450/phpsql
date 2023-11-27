<?php
// edit_rating_process.php
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

// Obsługa edytowania oceny
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating_id']) && isset($_POST['new_rating'])) {
    $rating_id = $_POST['rating_id'];
    $new_rating = $_POST['new_rating'];

    // Tutaj dodaj kod do aktualizacji oceny w bazie danych
    // np. UPDATE ratings SET rating=$new_rating WHERE id=$rating_id;

    // Pomyślne zaktualizowanie oceny, przekieruj na stronę z zarządzaniem kursami
    header("Location: manage_courses.php");
}

$conn->close();
?>

