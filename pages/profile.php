<!-- pages/profile.php -->

<?php session_start();
// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}
include('../settings.php');
// Pobierz informacje o zalogowanym użytkowniku (możesz pobierać więcej informacji z bazy danych, jeśli potrzebujesz)
$username = $_SESSION['username']; ?>
<?php include '../includes/header.php'; ?>

<div class="container login_h2">
    <h2>Profil Użytkownika</h2>
    <!-- ... Treść strony profilu ... -->
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
            echo 'Nie ukończyłeś jeszcze żadnych kursów';
            echo "<br>";
        }
        ?>

    <!-- Dodaj ten link do panelu użytkownika -->
    <a href="/phpsql/pages/user_panel.php">Panel użytkownika</a>
</div>

<?php include '../includes/footer.php'; ?>
