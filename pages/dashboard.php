<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Panel Użytkownika</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h2>Witaj, <?php echo $_SESSION['username']; ?>!</h2>
        <p>To jest twój panel użytkownika.</p>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
