<?php
// delete_user_process.php
session_start();

// Sprawdź, czy użytkownik jest zalogowany i ma rolę admina
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include('../settings.php');

// Obsługa usuwania użytkownika po potwierdzeniu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Sprawdź, czy użytkownik nie próbuje usunąć samego siebie
    if ($user_id == $_SESSION['user_id']) {
        $_SESSION['error_message'] = "Nie możesz usunąć swojego własnego konta.";
        header("Location: /phpsql/pages/admin_panel.php");
        exit;
    }

    // Usuń oceny kursów utworzonych przez użytkownika
    $deleteUserCourseRatingsSql = "DELETE cr FROM course_ratings cr 
                                    JOIN courses c ON cr.course_id = c.id
                                    WHERE c.creator_id = ?";
    $stmtUserCourseRatings = $conn->prepare($deleteUserCourseRatingsSql);
    $stmtUserCourseRatings->bind_param("i", $user_id);
    if ($stmtUserCourseRatings->execute()) {
        $stmtUserCourseRatings->close();
    } else {
        echo "Błąd usuwania ocen kursów utworzonych przez użytkownika: " . $stmtUserCourseRatings->error;
        $stmtUserCourseRatings->close();
    }

    // Usuń oceny kursów wystawione przez użytkownika
    $deleteUserRatingsSql = "DELETE FROM course_ratings WHERE user_id = ?";
    $stmtUserRatings = $conn->prepare($deleteUserRatingsSql);
    $stmtUserRatings->bind_param("i", $user_id);
    if ($stmtUserRatings->execute()) {
        $stmtUserRatings->close();
    } else {
        echo "Błąd usuwania ocen kursów wystawionych przez użytkownika: " . $stmtUserRatings->error;
        $stmtUserRatings->close();
    }

    // Usuń zależności od użytkownika w innych tabelach
    $deleteCompletedCoursesSql = "DELETE FROM completed_courses WHERE user_id = ?";
    $stmtCompletedCourses = $conn->prepare($deleteCompletedCoursesSql);
    $stmtCompletedCourses->bind_param("i", $user_id);
    if ($stmtCompletedCourses->execute()) {
        $stmtCompletedCourses->close();
    } else {
        echo "Błąd usuwania zależności od użytkownika w tabeli completed_courses: " . $stmtCompletedCourses->error;
        $stmtCompletedCourses->close();
    }

    // Usuń kursy utworzone przez użytkownika
    $deleteUserCoursesSql = "DELETE FROM courses WHERE creator_id = ?";
    $stmtUserCourses = $conn->prepare($deleteUserCoursesSql);
    $stmtUserCourses->bind_param("i", $user_id);
    if ($stmtUserCourses->execute()) {
        $stmtUserCourses->close();
    } else {
        echo "Błąd usuwania kursów utworzonych przez użytkownika: " . $stmtUserCourses->error;
        $stmtUserCourses->close();
    }

    // Usuń użytkownika z bazy danych
    $deleteUserSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteUserSql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $stmt->close();
    } else {
        echo "Błąd usuwania użytkownika: " . $stmt->error;
        $stmt->close();
    }

    $_SESSION['success_message'] = "Użytkownik został pomyślnie usunięty.";

    // Przekieruj z powrotem do panelu administratora
    header("Location: /phpsql/pages/admin_panel.php");
    exit;
} else {
    $_SESSION['error_message'] = "Nieprawidłowe żądanie usuwania użytkownika.";
    header("Location: /phpsql/pages/admin_panel.php");
    exit;
}
?>
