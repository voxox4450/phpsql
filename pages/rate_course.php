<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Oceń Kurs</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Oceń Kurs</h2>
        <?php
            // Tutaj dodaj kod do pobierania danych kursu na podstawie przekazanego ID (z $_GET['id'])
            // i wyświetlania ich na stronie
        ?>
        <form action="rate_course_process.php" method="post">
            <input type="hidden" name="course_id" value="ID_KURSU">
            
            <label for="rating">Twoja ocena (od 1 do 5):</label>
            <input type="number" name="rating" min="1" max="5" required>

            <button type="submit">Oceń</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
