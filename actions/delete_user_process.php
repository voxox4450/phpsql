<?php
// delete_user_process.php
session_start();

// Sprawdź, czy użytkownik jest zalogowany i ma rolę admina
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: /phpsql/pages/login.php");
    exit;
}

include('../settings.php');

// Obsługa usuwania użytkownika po potwierdzeniu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Sprawdź, czy użytkownik nie próbuje usunąć samego siebie
    if ($user_id == $_SESSION['user_id']) {
        $_SESSION['error_message'] = "Nie możesz usunąć swojego własnego konta.";
        header("Location: /phpsql/pages/admin_panel.php");
        exit;
    }

    // Przygotuj i wykonaj zapytanie do usuwania użytkownika z bazy danych
    $deleteUserSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteUserSql);
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        echo "Błąd usuwania użytkownika: " . $stmt->error;
        exit;
    }
    $stmt->close();

    $_SESSION['success_message'] = "Użytkownik został pomyślnie usunięty.";

    // Przekieruj z powrotem do panelu administratora
    header("Location: /phpsql/pages/admin_panel.php");
    exit;
} else {
    $_SESSION['error_message'] = "Nieprawidłowe żądanie usuwania użytkownika.";
    header("Location: /phpsql/pages/admin_panel.php");
    exit;
}
?>
