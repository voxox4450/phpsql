<?php
session_start();

include('../settings.php');

// Pobierz ID kursu z parametru w URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Pobierz dane kursu na podstawie ID
    $selectCourseSql = "SELECT * FROM courses WHERE id=$course_id";
    $courseResult = $conn->query($selectCourseSql);

    if ($courseResult->num_rows > 0) {
        $courseData = $courseResult->fetch_assoc();
        $title = $courseData['title'];
        $description = $courseData['description'];
        $creator_id = $courseData['creator_id'];

        // Pobierz imię twórcy na podstawie ID
        $selectCreatorSql = "SELECT username FROM users WHERE id=$creator_id";
        $creatorResult = $conn->query($selectCreatorSql);

        if ($creatorResult->num_rows > 0) {
            $creatorData = $creatorResult->fetch_assoc();
            $creator_name = $creatorData['username'];
        }
    }

    // Pobierz średnią ocenę kursu na podstawie ID kursu
    $selectAvgRatingSql = "SELECT AVG(rating) as avg_rating FROM course_ratings WHERE course_id=$course_id";
    $avgRatingResult = $conn->query($selectAvgRatingSql);

    if ($avgRatingResult->num_rows > 0) {
        $avgRatingData = $avgRatingResult->fetch_assoc();
        $average_rating = $avgRatingData['avg_rating'];
    }

    // Pobierz oceny kursu na podstawie ID kursu
    $selectRatingsSql = "SELECT * FROM course_ratings WHERE course_id=$course_id";
    $ratingsResult = $conn->query($selectRatingsSql);

    $ratings = array(); // Inicjalizacja tablicy do przechowywania ocen

    if ($ratingsResult->num_rows > 0) {
        while ($ratingData = $ratingsResult->fetch_assoc()) {
            $ratings[] = $ratingData['rating'];
        }
    }
}

include '../includes/header.php';
?>

<div class="container">
    <h2>Przeglądaj Kurs</h2>
    <?php
    // Wyświetl dane
    echo '<p>Tytuł: ' . $title . '</p>';
    echo '<p>Opis: ' . $description . '</p>';
    echo '<p>Twórca: ' . $creator_name . '</p>';

    // Wyświetl dane
    echo '<p>Średnia ocena: ' . $average_rating . '</p>';

    // Wyświetl oceny
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

    // Dodaj formularz oceny tylko dla zalogowanych użytkowników
    if (isset($_SESSION['user_id'])) {
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
    }
    ?>
</div>

<?php include '../includes/footer.php'; ?>
