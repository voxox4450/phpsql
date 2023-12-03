Specyfikacja projektu PHP/MySQL
===============================

**Opis instalacji:**
1. Umieszczenie projektu w `/xampp/htdocs`
2. Utworzenie pliku `settings.php` w katalogu głównym obok `index.php` (zawartość pliku do localhosta umieszczamy w załączniku dokumentacji, ponieważ pliki z hasłami powinny być ignorowane przez GitHub, w celu bezpieczeństwa danych)
3. Uruchomienie XAMPP i otworzenie strony `localhost/phpsql`

**Konfiguracja:**
- Po uruchomieniu strony, można zalogować się na użytkownika admin o haśle: admin. Przy próbie połączenia z bazą danych, która nie istnieje zostanie ona utworzona wraz z użytkownikiem admin.

**Opis funkcji:**
Po uruchomieniu strony jako niezalogowany użytkownik mamy dostęp do:
- Strony głównej
- Logowania
- Rejestrowania
- Przeglądania listy kursów

Jako zalogowany użytkownik, zyskujemy dodatkowo możliwość:
- Wyświetlania kursów
- Ukończenia kursów
- Po ukończeniu kursu oceny go w skali 1-5
- W panelu użytkownika:
  - Dodawania
  - Usuwania
  - Edytowania własnych kursów
  - Zmiany hasła
  - Zmiany nazwy użytkownika
  - Wylogowywania się
- Wyświetlenia profilu, na którym widnieją nasze ukończone kursy

Jako administrator zyskujemy dodatkowo możliwość:
- Otworzenia panelu administratora, w którym możemy:
  - Zmieniać uprawnienia (role) użytkowników
  - Usuwać użytkowników (co powoduje również usunięcie ich kursów oraz ocen)
  - Edytować kursy użytkowników
  - Usuwać kursy użytkowników (co powoduje również usunięcie ocen konkretnego kursu)

**Settings.php:**

```php
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
