<?php
// edit_profile.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Połączenie z bazą danych (zakładam, że masz już plik settings.php z konfiguracją)
include '../settings.php';

// Pobierz informacje o zalogowanym użytkowniku
$username = $_SESSION['username'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userId = $row['id'];
    $userRole = $row['role'];
} else {
    // Użytkownik nie istnieje w bazie danych (coś poszło nie tak)
    header("Location: /phpsql/pages/login.php");
    exit;
}

// Obsługa formularza edycji profilu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobierz dane z formularza
    $newUsername = validate($_POST['new_username']);

    // Dodatkowa walidacja dla nazwy użytkownika
    if (strlen($newUsername) < 5) {
        $error_message = "Nowa nazwa użytkownika musi mieć co najmniej 5 znaków.";
    } else {
        // Aktualizuj dane użytkownika w bazie danych
        $updateSql = "UPDATE users SET username='$newUsername' WHERE id=$userId";

        if ($conn->query($updateSql) === TRUE) {
            // Aktualizacja zakończona sukcesem
            $_SESSION['username'] = $newUsername; // Zaktualizuj dane sesji
            header("Location: /phpsql/pages/profile.php");
            exit;
        } else {
            // Błąd podczas aktualizacji
            $error_message = "Błąd podczas aktualizacji danych. Spróbuj ponownie.";
        }
    }
}

$conn->close();

// Funkcja do walidacji danych
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Edytuj Profil</title>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container width_30">
        <h2 class="login_h2">Edytuj Profil</h2>

        <form class="flex_column gap_5" action="edit_profile.php" method="post">
            <div class="flex_column gap_4">  
                <label for="new_username">Nowa Nazwa Użytkownika:</label>
                <input type="text" name="new_username" value="<?php echo $username; ?>" required>
            </div>
        
            <button type="submit">Zapisz Zmiany</button>
        </form>
        
        <?php
        if (isset($error_message)) {
            echo '<p class="error">' . $error_message . '</p>';
        }
        ?>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
