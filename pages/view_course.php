<!-- pages/view_course.php -->
<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../settings.php');


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
    foreach ($ratings as $rating) {
        echo '<li>' . $rating . '</li>';
    }
    echo '</ul>';

    // Dodaj ten link tylko dla użytkownika, który ocenił kurs
    echo '<a href="delete_rating.php?course_id=' . $course_id . '">Usuń moją ocenę</a>';

    // Dodaj ten link tylko dla użytkownika, który ocenił kurs
    echo '<a href="edit_rating.php?course_id=' . $course_id . '">Edytuj moją ocenę</a>';
    ?>
</div>

<?php include '../includes/footer.php'; ?>
