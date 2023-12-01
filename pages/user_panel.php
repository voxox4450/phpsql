<?php
// user_panel.php

session_start();
include('../settings.php');
// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}
echo "Rola użytkownika: " . $_SESSION['role'];

// Pobierz informacje o zalogowanym użytkowniku (możesz pobierać więcej informacji z bazy danych, jeśli potrzebujesz)
$username = $_SESSION['username'];

// Poniżej możesz umieścić kod HTML/CSS, który wyświetli panel użytkownika
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Panel Użytkownika</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2 class ='login_h2'>Witaj, <?php echo $username; ?>, w Twoim Panelu Użytkownika!</h2>

        <!-- Dodaj linki do różnych funkcji dostępnych dla zalogowanego użytkownika -->
        <ul>
            <li><a href="/phpsql/pages/manage_courses.php">Zarządzaj swoimi kursami</a></li>
            <li><a href="/phpsql/pages/edit_profile.php">Edytuj Profil</a></li>
            <li><a href="/phpsql/pages/change_password.php">Zmień Hasło</a></li>
        </ul>

        <!-- Dodaj sekcję wyświetlającą ukończone kursy danego uczestnika -->
        <h3>Twoje ukończone kursy:</h3>
        <?php
        // Pobierz ukończone kursy z bazy danych
        $user_id = $_SESSION['user_id'];

        $completedCoursesSql = "SELECT courses.title, completed_courses.completion_date
                               FROM courses
                               INNER JOIN completed_courses ON courses.id = completed_courses.course_id
                               WHERE completed_courses.user_id = $user_id";

        $completedCoursesResult = $conn->query($completedCoursesSql);

        if ($completedCoursesResult->num_rows > 0) {
            echo '<ul>';
            while ($row = $completedCoursesResult->fetch_assoc()) {
                echo '<li>' . $row['title'] . ' - Data ukończenia: ' . $row['completion_date'] . '</li>';
            }
            echo '</ul>';
        } else {
            echo 'Nie ukończyłeś jeszcze żadnych kursów.';
        }
        ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
