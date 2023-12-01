<!-- pages/profile.php -->

<?php session_start();
// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}
// Pobierz informacje o zalogowanym użytkowniku (możesz pobierać więcej informacji z bazy danych, jeśli potrzebujesz)
$username = $_SESSION['username']; ?>
<?php include '../includes/header.php'; ?>

<div class="container login_h2">
    <h2>Profil Użytkownika</h2>
    <!-- ... Treść strony profilu ... -->
    echo 'Nie ukończyłeś jeszcze żadnych kursów.';

    <!-- Dodaj ten link do panelu użytkownika -->
    <a href="/phpsql/pages/user_panel.php">Panel użytkownika</a>
</div>

<?php include '../includes/footer.php'; ?>
