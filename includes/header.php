<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Moja Aplikacja</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/phpsql/index.php">Strona główna</a></li>
                <?php
                $role = $_SESSION['role'];
                if (isset($_SESSION['username'])) {
                    if ($role == 'admin') {
                        // Jeśli użytkownik jest administratorem, wyświetl panel administratora
                        echo '<li><a href="/phpsql/pages/admin_panel.php">Panel administratora</a></li>';
                    } else {
                        // W przeciwnym razie wyświetl panel użytkownika
                        echo '<li><a href="/phpsql/pages/user_panel.php">Panel użytkownika</a></li>';
                    }
                    echo '<li><a href="/phpsql/pages/profile.php">Profil</a></li>';
                    echo '<li><a href="/phpsql/pages/logout.php">Wyloguj</a></li>';
                    echo '<li><a href="/phpsql/pages/courses.php">Kursy</a></li>';
                } else {
                    echo '<li><a href="/phpsql/pages/login.php">Zaloguj</a></li>';
                    echo '<li><a href="/phpsql/pages/register.php">Zarejestruj się</a></li>';
                    echo '<li><a href="/phpsql/pages/courses.php">Kursy</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
</body>
</html>
