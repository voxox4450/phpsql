<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany i ma rolę admina
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include '../settings.php';

// Pobierz wszystkich użytkowników
$getUsersSql = "SELECT id, username, role FROM users";
$usersResult = $conn->query($getUsersSql);

// Pobierz wszystkie kursy
$getCoursesSql = "SELECT id, title, description FROM courses";
$coursesResult = $conn->query($getCoursesSql);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Panel Administratora</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2 class = 'login_h2'>Panel Administratora</h2>

         <!-- Wyświetlanie użytkowników -->
        <h3 class='login_h2'>Użytkownicy</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nazwa użytkownika</th>
                <th>Rola</th>
                <th>Akcje</th>
            </tr>
            <?php while ($user = $usersResult->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td>
                        <?php
                        if ($_SESSION['user_id'] != $user['id']) {
                            // Dodaj link do edycji użytkownika tylko jeśli to nie jest aktualnie zalogowany użytkownik
                            echo '<a href="edit_user.php?id=' . $user['id'] . '">Edytuj</a>';

                            // Dodaj link do usuwania użytkownika tylko jeśli to nie jest aktualnie zalogowany użytkownik
                            echo '<a href="delete_user.php?id=' . $user['id'] . '">Usuń</a>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>



        <!-- Wyświetlanie kursów -->
        <h3 class = 'login_h2'>Kursy</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Opis</th>
                <th>Akcje</th>
            </tr>
            <?php while ($course = $coursesResult->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $course['id']; ?></td>
                    <td><?php echo $course['title']; ?></td>
                    <td><?php echo $course['description']; ?></td>
                    <td>
                        <a href="edit_course.php?id=<?php echo $course['id']; ?>">Edytuj</a>
                        <a href="delete_course.php?id=<?php echo $course['id']; ?>">Usuń</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
