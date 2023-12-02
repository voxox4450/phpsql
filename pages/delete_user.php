<?php
// delete_user.php
session_start();

// Sprawdź, czy użytkownik jest zalogowany i ma rolę admina
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include('../settings.php');

// Obsługa usuwania użytkownika
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Pobierz dane użytkownika na podstawie ID
    $selectUserSql = "SELECT id, username FROM users WHERE id=$user_id";
    $userResult = $conn->query($selectUserSql);

    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $username = $userData['username'];
    }

    include '../includes/header.php';
    ?>

    <div class="container width_30">
        <h2 class = 'login_h2'>Usuń Użytkownika</h2>
        <div class="flex_column gap_4">
        <p>Czy na pewno chcesz usunąć poniższego użytkownika?</p>
        <p>Nazwa użytkownika: <?php echo $username; ?></p>
        <form class = 'flex_column gap_5' action="/phpsql/actions/delete_user_process.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <button type="submit">Usuń</button>
        </form>
        </div>
    </div>

    <?php
    include '../includes/footer.php';
}

$conn->close();
?>
