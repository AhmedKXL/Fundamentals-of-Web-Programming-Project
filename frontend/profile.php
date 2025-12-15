<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include("./php/connectToDB.php");

$sql = "SELECT * FROM Accounts NATURAL JOIN Users NATURAL JOIN Scores NATURAL JOIN Games WHERE user_id={$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | GamersHub</title>
    <link rel="stylesheet" href="./styles/home.css">
    <link rel="stylesheet" href="./styles/profile.css">
    <script src="./js/profile.js" defer></script>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <div class="logo"></div>
        <nav class="nav">
            <a href="./index.php">Home</a>
            <a href="./about.html">About</a>
            <a href="./php/logout.php" class="login">Logout</a>
        </nav>
    </header>

    <section class="profile">
        <div class="photo-and-name">
            <div class="profile-pic">
                <img src="./other_images/profile.jpg" alt="Profile Picture" height="200px"/>
            </div>
            <div>
                <h2 class="full-name"><?php echo $row['full_name']; ?></h2>
                <p class="username"><?php echo $row['username']; ?></p>
            </div>
            <!-- <button class="edit-profile" onclick="toggleEditMode()">Edit Profile</button> -->
        </div>

        <form class="personal-info" id="personal-info-form" method="POST" action="./php/update_profile.php">
            <h3 class="personal-information">Personal Information</h3>
            <div class="line"></div>
            <div>
                <span class="input-section">
                    <label for="gender">Gender:</label>
                    <select id="gender" class="input-field" name="gender" disabled>
                        <option value="male" <?php if($row['gender'] == 'male') echo 'selected'; ?>>Male</option>
                        <option value="female" <?php if($row['gender'] == 'female') echo 'selected'; ?>>Female</option>
                        <option value="prefer_not_to_say" <?php if($row['gender'] == 'prefer_not_to_say') echo 'selected'; ?>>Prefer Not to Tell</option>
                    </select>
                </span>

                <span class="input-section">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" class="input-field" name="dob" value="<?php echo $row['date_of_birth']; ?>" disabled>
                </span>

                <span class="input-section">
                    <label for="timezone">Time Zone:</label>
                    <input type="text" id="timezone" class="input-field" name="timezone" value="<?php echo $row['time_zone']; ?>" disabled>
                </span>
            </div>
        </form>

        <form class="contact-info" id="contact-info-form" method="POST" action="./php/update_profile.php">
            <h3 class="contact-information">Contact Information</h3>
            <div class="line"></div>
            <div>
                <span class="input-section">
                    <label for="email">Email:</label>
                    <input type="email" id="email" class="input-field" name="email" value="<?php echo $row['email']; ?>" disabled>
                </span>

                <span class="input-section">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" class="input-field" name="phone" value="<?php echo $row['phone_number']; ?>" disabled>
                </span>
            </div>
        </form>

        <div class="high-scores">
            <h3>Scores</h3>
            <div class="line"></div>
            <table class="leaderboard-profile">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through the games and scores (assuming result has multiple rows)
                    do {
                        echo "<tr>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['score']}</td>";
                        echo "</tr>";
                    } while ($row = mysqli_fetch_assoc($result));
                    ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section links">
                <h2>Quick Links</h2>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h2>Contact</h2>
                <p>Email: support@gamershub.com</p>
                <p>&copy; 2025 GamersHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
