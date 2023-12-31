<?php
// user_panel.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Pobierz informacje o zalogowanym użytkowniku (możesz pobierać więcej informacji z bazy danych, jeśli potrzebujesz)
$username = $_SESSION['username'];
$course_id = $_GET['id'];
// Poniżej możesz umieścić kod HTML/CSS, który wyświetli panel użytkownika
?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edytuj Kurs</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container width_30">
        <h2 class='login_h2'>Edytuj Kurs</h2>
      
        <form class='flex_column gap_5' action="/phpsql/actions/edit_course_process.php" method="post">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <div class="flex_column gap_4">
            <label for="title">Tytuł kursu:</label>
            <input type="text" name="title" value="" required>
        </div>
        <div class="flex_column gap_4">
            <label for="description">Opis kursu:</label>
            <textarea name="description" rows="4" required></textarea>
        </div>

            <button type="submit">Zapisz zmiany</button>
        </form>
        <?php
            // Obsługa komunikatu o błędzie
            if (isset($_GET['error']) && !empty($_GET['error'])) {
                echo '<div class="error">';
                echo '<p>' . $_GET['error'] . '</p>';
                echo '</div>';
            }

            // Tutaj dodaj kod do pobierania danych kursu na podstawie przekazanego ID (z $_GET['id'])
            // i wypełnij nimi formularz edycji
        ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
