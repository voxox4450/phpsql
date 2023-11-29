<?php
session_start();

include('../settings.php');

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Sprawdź, czy przesłano poprawne dane POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id']) && isset($_POST['complete_course'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];

    // Sprawdź, czy użytkownik już ukończył ten kurs
    $checkCompletionSql = "SELECT * FROM completed_courses WHERE user_id=$user_id AND course_id=$course_id";
    $result = $conn->query($checkCompletionSql);

    if ($result->num_rows == 0) {
        // Użytkownik jeszcze nie ukończył kursu, dodaj do tabeli completed_courses
        $insertCompletionSql = "INSERT INTO completed_courses (user_id, course_id, completion_date) VALUES ($user_id, $course_id, CURDATE())";
        if ($conn->query($insertCompletionSql)) {
            // Przekieruj na stronę przeglądania kursu po ukończeniu
            header("Location: /phpsql/pages/view_course.php?id=$course_id");
            exit;
        } else {
            echo "Błąd podczas rozpoczynania kursu: " . $conn->error;
        }
    } else {
        // Użytkownik już ukończył kurs, zaktualizuj datę ukończenia
        $updateCompletionSql = "UPDATE completed_courses SET completion_date = CURDATE() WHERE user_id=$user_id AND course_id=$course_id";
        if ($conn->query($updateCompletionSql)) {
            // Przekieruj na stronę przeglądania kursu po ponownym ukończeniu
            header("Location: /phpsql/pages/view_course.php?id=$course_id");
            exit;
        } else {
            echo "Błąd podczas ponownego ukończania kursu: " . $conn->error;
        }
    }
} else {
    echo "Błędne dane przesłane do formularza.";
}

$conn->close();
?>
