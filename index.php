<!DOCTYPE html>
<?php 
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Platforma Kursów Online</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1 class='login_h2'>Witaj na Platformie Kursów Online</h1>
        <?php 
         if (isset($_SESSION['username'])) {
        <p class = "main_p"><a href='/phpsql/pages/login.php'> Zaloguj się </a> lub <a href= '/phpsql/pages/register.php'> zarejestruj</a> , aby rozpocząć naukę.</p>
         }
        ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
