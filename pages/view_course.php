<?php
session_start();

include('../settings.php');

// Pobierz ID kursu z parametru w URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Pobierz dane kursu na podstawie ID
    $selectCourseSql = "SELECT * FROM courses WHERE id={$course_id}";
    $courseResult = $conn->query($selectCourseSql);

    // ... (reszta kodu bez zmian)

    // Sprawdź, czy użytkownik jest zalogowany
    if (isset($_SESSION['user_id'])) {
        // Sprawdź, czy użytkownik ukończył kurs
        $checkCompletionSql = "SELECT * FROM completed_courses WHERE user_id={$_SESSION['user_id']} AND course_id={$course_id}";
        $result = $conn->query($checkCompletionSql);

        include '../includes/header.php';

        if ($result->num_rows > 0) {
            // Użytkownik ukończył kurs, umożliwiamy ocenę
            echo '<div class="container">';
            echo '<h2>Przeglądaj Kurs</h2>';
            echo '<p>Tytuł: ' . $title . '</p>';
            echo '<p>Opis: ' . $description . '</p>';
            echo '<p>Twórca: ' . $creator_name . '</p>';
            echo '<p>Średnia ocena: ' . $average_rating . '</p>';
            echo '<h3>Oceny kursu:</h3>';
            echo '<ul>';
            if (!empty($ratings)) {
                foreach ($ratings as $rating) {
                    echo '<li>' . $rating . '</li>';
                }
            } else {
                echo '<li>Brak ocen.</li>';
            }
            echo '</ul>';

            // Dodaj przycisk "Rozpocznij Kurs Ponownie"
            echo '<h3>Oceń kurs:</h3>';
            echo '<form method="post" action="../actions/rate_course_process.php">';
            echo '<input type="hidden" name="course_id" value="' . $course_id . '">';
            echo '<label for="rating">Wybierz ocenę od 1 do 5:</label>';
            echo '<select name="rating" required>';
            echo '<option value="1">1 gwiazdka</option>';
            echo '<option value="2">2 gwiazdki</option>';
            echo '<option value="3">3 gwiazdki</option>';
            echo '<option value="4">4 gwiazdki</option>';
            echo '<option value="5">5 gwiazdek</option>';
            echo '</select>';
            echo '<button type="submit">Oceń</button>';
            echo '</form>';

            // Dodaj przycisk "Rozpocznij Kurs Ponownie"
            echo '<form method="post" action="/phpsql/actions/start_course.php">';
            echo '<input type="hidden" name="course_id" value="' . $course_id . '">';
            echo '<button type="submit">Rozpocznij Kurs Ponownie</button>';
            echo '</form>';
        } else {
            // Użytkownik nie ukończył kursu, przekieruj na stronę rozpoczęcia kursu
            echo '<div class="container">';
            echo '<h2>Przeglądaj Kurs</h2>';
            echo '<p>Tytuł: ' . $title . '</p>';
            echo '<p>Opis: ' . $description . '</p>';
            echo '<p>Twórca: ' . $creator_name . '</p>';
            echo '<p>Średnia ocena: ' . $average_rating . '</p>';
            echo '<h3>Oceny kursu:</h3>';
            echo '<ul>';
            if (!empty($ratings)) {
                foreach ($ratings as $rating) {
                    echo '<li>' . $rating . '</li>';
                }
            } else {
                echo '<li>Brak ocen.</li>';
            }
            echo '</ul>';

            // Dodaj przycisk "Rozpocznij Kurs"
            echo '<form method="post" action="/phpsql/actions/start_course.php">';
            echo '<input type="hidden" name="course_id" value="' . $course_id . '">';
            echo '<button type="submit">Rozpocznij Kurs</button>';
            echo '</form>';
        }

        echo '</div>'; // Zamknij kontener
        include '../includes/footer.php';
    } else {
        // Użytkownik nie jest zalogowany, przekieruj na stronę logowania
        header("Location: /phpsql/pages/login.php");
        exit;
    }
}
?>
