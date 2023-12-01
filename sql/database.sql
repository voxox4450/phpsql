-- Tworzenie bazy danych
CREATE DATABASE IF NOT EXISTS online_courses;

-- Używanie nowo utworzonej bazy danych
USE online_courses;

-- Tabela użytkowników
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Tabela kursów
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    creator_id INT NOT NULL,
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela ocen kursów
CREATE TABLE IF NOT EXISTS course_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(course_id, user_id) -- Zapewnia, że jeden użytkownik może ocenić dany kurs tylko raz
);

-- Tabela ukończonych kursów przez użytkowników
CREATE TABLE IF NOT EXISTS completed_courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    completion_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Dodano ON DELETE CASCADE
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE, -- Dodano ON DELETE CASCADE
    UNIQUE(user_id, course_id) -- Zapewnia, że jeden użytkownik może ukończyć dany kurs tylko raz
);

-- Trigger do automatycznego wpisywania completion date po ukończeniu kursu
DELIMITER //
CREATE TRIGGER after_completed_courses_insert
AFTER INSERT ON completed_courses
FOR EACH ROW
BEGIN
    UPDATE completed_courses
    SET completion_date = CURDATE()
    WHERE id = NEW.id;
END;
//
DELIMITER ;
