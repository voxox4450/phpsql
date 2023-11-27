<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Wyszukaj Kursy</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Wyszukaj Kursy</h2>
        <form action="search_courses_process.php" method="get">
            <label for="query">Wprowadź zapytanie:</label>
            <input type="text" name="query" required>

            <button type="submit">Szukaj</button>
        </form>
        <!-- Tutaj możesz wyświetlać wyniki wyszukiwania -->
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
