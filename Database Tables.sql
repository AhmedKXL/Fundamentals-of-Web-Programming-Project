/*
Key Points:

The Users table holds the user's profile data, like name, gender, and contact info.

The Accounts table links each user to their login details (username, password).

The Games table stores the games available.

The Scores table records the scores for each user per game.
*/

CREATE DATABASE IF NOT EXISTS GAME_WEBSITE;

USE GAME_WEBSITE;

CREATE TABLE Accounts (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL -- Hashed password (e.g., bcrypt)
);

CREATE TABLE Users (
    user_id INT PRIMARY KEY NOT NULL,
    profile_picture VARCHAR(255) DEFAULT 'default.jpg', -- File name of the avatar image
    full_name VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female', 'prefer_not_to_say') NOT NULL,
    date_of_birth DATE NOT NULL,
    email VARCHAR(100),
    phone_number VARCHAR(20),
    time_zone VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES Accounts(user_id) ON DELETE CASCADE
);

CREATE TABLE Games (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE Scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game_id INT NOT NULL,
    score INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Accounts(user_id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES Games(game_id) ON DELETE CASCADE
);

INSERT INTO games (game_id, name) VALUES
(1, 'Tic-Tac-Toe'),
(2, 'Snake'),
(3, 'Neat Nine'),
(4, 'Matching'),
(5, 'Connect-4'),
(6, '2048'),
(7, 'Finance!'),
(8, 'Mine Sweeper'),
(9, 'Simon Says')
ON DUPLICATE KEY UPDATE name = VALUES(name);
