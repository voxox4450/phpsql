<?php
// delete_course.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../settings.php');

// Obsługa usuwania kursu
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

    include '../includes/header.php';
    ?>

    <div class="container">
        <h2>Usuń Kurs</h2>
        <p>Czy na pewno chcesz usunąć poniższy kurs?</p>
        <p>Tytuł: <?php echo $title; ?></p>
        <p>Opis: <?php echo $description; ?></p>
        <p>Twórca: <?php echo $creator_name; ?></p>
        <form action="/phpsql/actions/delete_course_process.php" method="post">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <button type="submit">Usuń</button>
        </form>
    </div>

    <?php
    include '../includes/footer.php';
}

$conn->close();
?>
