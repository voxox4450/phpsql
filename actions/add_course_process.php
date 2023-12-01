<?php
// add_course_process.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include('../settings.php');

// Funkcja walidująca
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Obsługa dodawania nowego kursu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz dane z formularza
    $title = validate($_POST['title']);
    $description = validate($_POST['description']);
    $creator_id = $_SESSION['user_id']; // Pobierz ID twórcy kursu z sesji

    // Walidacja tytułu
    if (strlen($title) < 6) {
        $_SESSION['error_messages'][] = "Tytuł musi mieć co najmniej 6 znaków.";
        header("Location: /phpsql/pages/browse_courses.php");
        exit;
    }

    // Walidacja opisu
    if (strlen($description) < 25) {
        $_SESSION['error_messages'][] = "Opis musi mieć co najmniej 25 znaków.";
        header("Location: /phpsql/pages/browse_courses.php");
        exit;
    }

    // Sprawdzenie, czy nie ma już kursu o tym samym tytule i opisie
    $checkExistingSql = "SELECT * FROM courses WHERE title='$title' AND description='$description'";
    $result = $conn->query($checkExistingSql);

    if ($result->num_rows > 0) {
        $_SESSION['error_messages'][] = "Istnieje już kurs o tym samym tytule i opisie.";
        header("Location: /phpsql/pages/browse_courses.php");
        exit;
    }

    // Dodanie nowego kursu do bazy danych
    $insertSql = "INSERT INTO courses (title, description, creator_id) VALUES ('$title', '$description', '$creator_id')";

    if ($conn->query($insertSql) === TRUE) {
        // Pomyślne dodanie kursu, przekieruj na stronę z kursami
        header("Location: /phpsql/pages/browse_courses.php");
        exit;
    } else {
        // Błąd podczas dodawania kursu
        $_SESSION['error_messages'][] = "Błąd podczas dodawania kursu. Spróbuj ponownie.";
        header("Location: /phpsql/pages/browse_courses.php");
        exit;
    }
}

$conn->close();
?>
