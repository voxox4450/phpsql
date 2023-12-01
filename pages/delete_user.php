<?php
// delete_user.php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('../settings.php');

// Obsługa usuwania użytkownika
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Pobierz dane użytkownika na podstawie ID
    $selectUserSql = "SELECT * FROM users WHERE id=$user_id";
    $userResult = $conn->query($selectUserSql);

    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $username = $userData['username'];
        $role = $userData['role'];
    }

    include '../includes/header.php';
    ?>

    <div class="container">
        <h2>Usuń Użytkownika</h2>
        <p>Czy na pewno chcesz usunąć poniższego użytkownika?</p>
        <p>Nazwa użytkownika: <?php echo $username; ?></p>
        <p>Rola: <?php echo $role; ?></p>
        <form action="/phpsql/pages/delete_user_process.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <button type="submit">Usuń</button>
        </form>
    </div>

    <?php
    include '../includes/footer.php';
}

$conn->close();
?>
