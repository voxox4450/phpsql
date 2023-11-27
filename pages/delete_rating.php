<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Usuń Ocenę</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Usuń Ocenę</h2>
        <?php
            // Tutaj dodaj kod do pobierania danych oceny na podstawie ID oceny (z $_GET['rating_id'])
            // i wyświetlania ich na stronie
        ?>
        <form action="delete_rating_process.php" method="post">
            <input type="hidden" name="rating_id" value="ID_OCENY">
            <input type="hidden" name="course_id" value="ID_KURSU">
            
            <p>Czy na pewno chcesz usunąć swoją ocenę?</p>

            <button type="submit">Tak, usuń ocenę</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
