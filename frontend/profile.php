<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include("./php/connectToDB.php");

$sql = "SELECT * FROM Accounts NATURAL JOIN Users WHERE user_id={$_SESSION['user_id']}";
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
            <button type="button" class="edit-profile">Edit Profile</button>
        </div>
        <form id="user-info" method="POST" action="./php/update_profile.php">
            <fieldset class="personal-info" id="personal-info-form">
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
                        <select id="timezone" name="timezone" class="input-field" disabled>
                            <option value="UTC-11" <?php if ($row['time_zone'] == 'UTC-11') echo 'selected'; ?>>UTC-11</option>
                            <option value="UTC-10" <?php if ($row['time_zone'] == 'UTC-10') echo 'selected'; ?>>UTC-10</option>
                            <option value="UTC-9"  <?php if ($row['time_zone'] == 'UTC-9')  echo 'selected'; ?>>UTC-9</option>
                            <option value="UTC-8"  <?php if ($row['time_zone'] == 'UTC-8')  echo 'selected'; ?>>UTC-8</option>
                            <option value="UTC-7"  <?php if ($row['time_zone'] == 'UTC-7')  echo 'selected'; ?>>UTC-7</option>
                            <option value="UTC-6"  <?php if ($row['time_zone'] == 'UTC-6')  echo 'selected'; ?>>UTC-6</option>
                            <option value="UTC-5"  <?php if ($row['time_zone'] == 'UTC-5')  echo 'selected'; ?>>UTC-5</option>
                            <option value="UTC-4"  <?php if ($row['time_zone'] == 'UTC-4')  echo 'selected'; ?>>UTC-4</option>
                            <option value="UTC-3"  <?php if ($row['time_zone'] == 'UTC-3')  echo 'selected'; ?>>UTC-3</option>
                            <option value="UTC-2"  <?php if ($row['time_zone'] == 'UTC-2')  echo 'selected'; ?>>UTC-2</option>
                            <option value="UTC-1"  <?php if ($row['time_zone'] == 'UTC-1')  echo 'selected'; ?>>UTC-1</option>
                            <option value="UTC+0"  <?php if ($row['time_zone'] == 'UTC+0')  echo 'selected'; ?>>UTC+0</option>
                            <option value="UTC+1"  <?php if ($row['time_zone'] == 'UTC+1')  echo 'selected'; ?>>UTC+1</option>
                            <option value="UTC+2"  <?php if ($row['time_zone'] == 'UTC+2')  echo 'selected'; ?>>UTC+2</option>
                            <option value="UTC+3"  <?php if ($row['time_zone'] == 'UTC+3')  echo 'selected'; ?>>UTC+3</option>
                            <option value="UTC+4"  <?php if ($row['time_zone'] == 'UTC+4')  echo 'selected'; ?>>UTC+4</option>
                            <option value="UTC+5"  <?php if ($row['time_zone'] == 'UTC+5')  echo 'selected'; ?>>UTC+5</option>
                            <option value="UTC+6"  <?php if ($row['time_zone'] == 'UTC+6')  echo 'selected'; ?>>UTC+6</option>
                            <option value="UTC+7"  <?php if ($row['time_zone'] == 'UTC+7')  echo 'selected'; ?>>UTC+7</option>
                            <option value="UTC+8"  <?php if ($row['time_zone'] == 'UTC+8')  echo 'selected'; ?>>UTC+8</option>
                            <option value="UTC+9"  <?php if ($row['time_zone'] == 'UTC+9')  echo 'selected'; ?>>UTC+9</option>
                            <option value="UTC+10" <?php if ($row['time_zone'] == 'UTC+10') echo 'selected'; ?>>UTC+10</option>
                            <option value="UTC+11" <?php if ($row['time_zone'] == 'UTC+11') echo 'selected'; ?>>UTC+11</option>
                            <option value="UTC+12" <?php if ($row['time_zone'] == 'UTC+12') echo 'selected'; ?>>UTC+12</option>
                        </select>
                    </span>
                </div>
            </fieldset>

            <fieldset class="contact-info" id="contact-info-form">
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
            </fieldset>
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
                        $sql = "SELECT * FROM Accounts NATURAL JOIN Users NATURAL JOIN Scores NATURAL JOIN Games WHERE user_id={$_SESSION['user_id']}";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0){
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>{$row['score']}</td>";
                                echo "</tr>";
                            }
                        }else{
                            echo "<tr><td colspan='2' style='color: #888; text-align: center; font-style: italic;'>No Scores</td></tr>";
                        }
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
