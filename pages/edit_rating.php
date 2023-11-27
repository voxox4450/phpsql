<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edytuj Ocenę</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Edytuj Ocenę</h2>
        <?php
            // Tutaj dodaj kod do pobierania danych oceny na podstawie ID oceny (z $_GET['id'])
            // i wyświetlania ich na stronie
        ?>
        <form action="edit_rating_process.php" method="post">
            <input type="hidden" name="rating_id" value="ID_OCENY">
            <input type="hidden" name="course_id" value="ID_KURSU">
            
            <label for="new_rating">Nowa ocena (od 1 do 5):</label>
            <input type="number" name="new_rating" min="1" max="5" required>

            <button type="submit">Zapisz zmiany</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
