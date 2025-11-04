/*
Key Points:

The Users table holds the user's profile data, like name, gender, and contact info.

The Accounts table links each user to their login details (username, password).

The Games table stores the games available.

The Scores table records the scores for each user per game.
*/

CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    profile_picture VARCHAR(255) DEFAULT '.jpg', -- File name of the avatar image
    full_name VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female', 'prefer_not_to_say') NOT NULL,
    date_of_birth DATE NOT NULL,
    email VARCHAR(100),
    phone_number VARCHAR(20),
    time_zone VARCHAR(10)
);

CREATE TABLE Accounts (
    user_id INT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Hashed password (e.g., bcrypt)
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Games (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    game_name VARCHAR(100) NOT NULL
);

CREATE TABLE Scores (
    user_id INT NOT NULL,
    game_id INT NOT NULL,
    score INT NOT NULL,
    PRIMARY KEY (user_id, game_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (game_id) REFERENCES Games(game_id)
);


