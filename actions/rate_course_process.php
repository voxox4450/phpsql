<!-- actions/rate_course_process.php -->
<?php
session_start();

include('../settings.php');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

// Sprawdź, czy formularz został przesłany
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating']) && isset($_POST['course_id'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $rating = $_POST['rating'];

    // Sprawdź, czy użytkownik już ocenił ten kurs
    $checkRatingSql = "SELECT * FROM course_ratings WHERE user_id=$user_id AND course_id=$course_id";
    $checkRatingResult = $conn->query($checkRatingSql);

    if ($checkRatingResult->num_rows > 0) {
        // Użytkownik już ocenił ten kurs, więc zaktualizuj ocenę
        $updateRatingSql = "UPDATE course_ratings SET rating=$rating WHERE user_id=$user_id AND course_id=$course_id";
        $conn->query($updateRatingSql);
    } else {
        // Użytkownik jeszcze nie ocenił tego kursu, więc dodaj nową ocenę
        $insertRatingSql = "INSERT INTO course_ratings (course_id, user_id, rating) VALUES ($course_id, $user_id, $rating)";
        $conn->query($insertRatingSql);
    }

    // Przekieruj, aby uniknąć wielokrotnego przesłania formularza
    header("Location: ../pages/view_course.php?id=$course_id");
    exit;
} else {
    // Jeśli formularz nie został przesłany, przekieruj na stronę główną
    header("Location: ../index.php");
    exit;
}
?>
