# phpsql
<?php
// Połączenie z bazą danych

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_courses";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sprawdź, czy baza danych już istnieje
if (!mysqli_select_db($conn, $dbname)) {
    // Utwórz bazę danych, jeśli nie istnieje
    $createDbSql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (mysqli_query($conn, $createDbSql)) {
        echo "Database created successfully\n";
    } else {
        die("Error creating database: " . mysqli_error($conn));
    }

    // Połącz z nowo utworzoną bazą danych
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Wykonaj zapytania do utworzenia tabel
    $sql = file_get_contents("../sql/database.sql");
    if (mysqli_multi_query($conn, $sql)) {
        do {
            // Pobierz i usuń wyniki z bufora
            if ($result = mysqli_store_result($conn)) {
                mysqli_free_result($result);
            }
        } while (mysqli_next_result($conn));
        echo "Tables created successfully\n";

        // Dodaj użytkownika admina
        $adminUsername = "admin";
        $adminPassword = password_hash("admin", PASSWORD_DEFAULT);
        $insertAdminSql = "INSERT INTO users (username, password, role) VALUES ('$adminUsername', '$adminPassword', 'admin')";
        if (mysqli_query($conn, $insertAdminSql)) {
            echo "Admin user added successfully\n";
        } else {
            echo "Error adding admin user: " . mysqli_error($conn);
        }
    } else {
        echo "Error creating tables: " . mysqli_error($conn);
    }
} else {
    // Baza danych już istnieje, możesz po prostu się połączyć
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
}
?>
