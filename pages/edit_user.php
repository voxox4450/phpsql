<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include '../settings.php';

// Sprawdź, czy przekazano ID użytkownika
if (!isset($_GET['id'])) {
    header("Location: admin_panel.php");
    exit;
}

// Pobierz dane użytkownika
$userId = $_GET['id'];
$getUserDataSql = "SELECT id, username, role FROM users WHERE id = $userId";
$userDataResult = $conn->query($getUserDataSql);

if ($userDataResult->num_rows === 0) {
    header("Location: admin_panel.php");
    exit;
}

$userData = $userDataResult->fetch_assoc();

// Obsługa edycji danych użytkownika
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newRole = $_POST['role'];

    // Zaktualizuj rolę użytkownika
    $updateRoleSql = "UPDATE users SET role = '$newRole' WHERE id = $userId";

    if ($conn->query($updateRoleSql) === TRUE) {
        // Pomyślnie zaktualizowano rolę
        header("Location: admin_panel.php");
        exit;
    } else {
        // Błąd aktualizacji
        echo "Błąd aktualizacji roli: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edytuj Użytkownika</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Edytuj Użytkownika</h2>

        <form action="" method="post">
            <label for="username">Nazwa użytkownika: <?php echo $userData['username']; ?></label>
            <input type="hidden" name="username" value="<?php echo $userData['username']; ?>" disabled>

            <label for="role">Rola:</label>
            <select name="role">
                <option value="user" <?php echo ($userData['role'] === 'user') ? 'selected' : ''; ?>>Użytkownik</option>
                <option value="admin" <?php echo ($userData['role'] === 'admin') ? 'selected' : ''; ?>>Administrator</option>
            </select>

            <button type="submit">Zapisz</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
