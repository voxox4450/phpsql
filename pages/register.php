<?php
session_start(); // Rozpoczęcie sesji

// Sprawdzenie, czy istnieje komunikat w sesji
$registration_message = isset($_SESSION['registration_message']) ? $_SESSION['registration_message'] : '';

// Usunięcie komunikatu z sesji, aby znikł po odświeżeniu strony
unset($_SESSION['registration_message']);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Rejestracja</title>
    <style>
        /* Dodaj odpowiednie style dla komunikatu */
        .registration-message {
            color: red; /* Kolor komunikatu o błędzie */
            font-weight: bold;
            /* Dodaj inne stylizacje według potrzeb */
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <h2>Zarejestruj się</h2>

        <?php
        // Wyświetlenie komunikatu
        if (!empty($registration_message)) {
            echo '<p class="registration-message">' . $registration_message . '</p>';
        }
        ?>

        <form action="/phpsql/actions/register_process.php" method="post">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" name="username" required>

            <label for="password">Hasło:</label>
            <input type="password" name="password" required>

            <button type="submit">Zarejestruj się</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
