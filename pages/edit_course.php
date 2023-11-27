<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edytuj Kurs</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Edytuj Kurs</h2>
        <?php
            // Tutaj dodaj kod do pobierania danych kursu na podstawie przekazanego ID (z $_GET['id'])
            // i wypełnij nimi formularz edycji
        ?>
        <form action="edit_course_process.php" method="post">
            <input type="hidden" name="course_id" value="ID_KURSU">
            
            <label for="title">Tytuł kursu:</label>
            <input type="text" name="title" value="WARTOŚĆ_TYTULU" required>

            <label for="description">Opis kursu:</label>
            <textarea name="description" rows="4" required>WARTOŚĆ_OPISU</textarea>

            <label for="instructor">Instruktor:</label>
            <input type="text" name="instructor" value="WARTOŚĆ_INSTRUKTORA" required>

            <button type="submit">Zapisz zmiany</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
