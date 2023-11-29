<?php
// change_password_process.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Dołączenie pliku z ustawieniami bazy danych
include '../settings.php';

// Pobranie informacji o zalogowanym użytkowniku
$username = $_SESSION['username'];

// Sprawdzenie połączenia z bazą danych
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
} else {
    // Użytkownik nie istnieje w bazie danych (coś poszło nie tak)
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Obsługa formularza zmiany hasła
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz dane z formularza
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmNewPassword = $_POST['confirm_new_password'];

    // Sprawdź, czy aktualne hasło jest poprawne
    if (password_verify($currentPassword, $row['password'])) {
        // Aktualne hasło jest poprawne
        if ($newPassword === $confirmNewPassword) {
            // Walidacja nowego hasła (możesz dostosować zasady walidacji)
            if (strlen($newPassword) < 8) {
                $error_message = "Nowe hasło musi mieć co najmniej 8 znaków.";
            } else {
                // Nowe hasło zostało potwierdzone
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Aktualizuj hasło w bazie danych (parametryzowane zapytanie)
                $updateSql = "UPDATE users SET password=? WHERE id=?";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param("si", $hashedNewPassword, $userId);

                if ($stmt->execute()) {
                    // Aktualizacja hasła zakończona sukcesem
                    header("Location: /phpsql/pages/profile.php");
                    exit;
                } else {
                    // Błąd podczas aktualizacji hasła
                    $error_message = "Błąd podczas aktualizacji hasła. Spróbuj ponownie.";
                }
            }
        } else {
            // Nowe hasła nie pasują do siebie
            $error_message = "Nowe hasło i jego potwierdzenie muszą być identyczne.";
        }
    } else {
        // Aktualne hasło jest niepoprawne
        $error_message = "Aktualne hasło jest niepoprawne.";
    }
}

$conn->close();
?>
