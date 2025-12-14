<?php
    session_start();
    include("connectToDB.php");
    $sql = "SELECT * FROM Accounts NATURAL JOIN Scores NATURAL JOIN Users NATURAL JOIN Games WHERE user_id='{$_SESSION['user_id']}'";   //need game id
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
    <div class="logo"><img src="../../2222222.jpg" alt="Logo" height="30px"></div>
    <nav class="nav">
      <a href="./index.php">Home</a>
      <a href="./about.html">About</a>
      <a href="./php/logout.php" class="login">Logout</a>
    </nav>
  </header>

  <section class="profile">
      <div class="photo-and-name">
          <div class="profile-pic"></div>
          <div>
              <h2 class="full-name"><?php echo $row['full_name']; ?></h2>
              <p class="username"><?php echo $row['username']; ?></p>
          </div>
          <button class="edit-profile">Edit Profile</button>
      </div>

      <form class="personal-info">
          <h3 class="personal-information">Personal Information</h3>
          <div class="line"></div>
          <div>
              <span class="input-section">
                  <label for="gender">Gender:</label>
                  <select id="gender" class="input-field" disabled>
                      <option value="male" <?php if($row['gender'] == 'male') echo 'selected'; ?>>Male</option>
                      <option value="female" <?php if($row['gender'] == 'female') echo 'selected'; ?>>Female</option>
                      <option value="prefer_not_to_say" <?php if($row['gender'] == 'prefer_not_to_say') echo 'selected'; ?>>Prefer Not to Tell</option>
                  </select>
              </span>
    
              <span class="input-section">
                  <label for="dob">Date of Birth:</label>
                  <input type="date" id="dob" class="input-field" value="<?php echo $row['date_of_birth']; ?>" disabled>
              </span>
              
              <span class="input-section">
                  <label for="timezone">Time Zone:</label>
                  <input type="text" id="timezone" class="input-field" value="<?php echo $row['time_zone']; ?>" disabled>
              </span>
          </div>
        </form>

      <form class="contact-info">
          <h3 class="contact-information">Contact Information</h3>
          <div class="line"></div>
          <div>
            <span class="input-section">
                <label for="email">Email:</label>
                <input type="email" id="email" class="input-field" value="<?php echo $row['email']; ?>" disabled>
            </span>
    
            <span class="input-section">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" class="input-field" value="<?php echo $row['phone_number']; ?>" disabled>
            </span>
          </div>
      </form>
<?php while($row = mysqli_fetch_assoc($result))   //loop all games and scores (run echo one time (first row) then loop echo) ?>
        <div class="high-scores">
            <h3>High Scores</h3>
            <div class="line"></div>
            <table class="leaderboard-profile">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="rank">Puzzle Game 1</td>
                        <td class="number-score">97</td>
                    </tr>
                    <tr>
                        <td class="rank">Puzzle Game 2</td>
                        <td class="number-score">83</td>
                    </tr>
                    <tr>
                        <td class="rank">Puzzle Game 3</td>
                        <td class="number-score">72</td>
                    </tr>
                    <tr>
                        <td class="rank">Puzzle Game 4</td>
                        <td class="number-score">45</td>
                    </tr>
                </tbody>
            </table>
        </div>

      </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
      <div class="footer-content">
          <div class="footer-section links">
              <h2>Quick Links</h2>
              <ul>
                  <li><a href="index.html">Home</a></li>
                  <li><a href="login.html">Login</a></li>
                  <li><a href="leaderboards.html">Leaderboard</a></li>
              </ul>
          </div>
          <div class="footer-section contact">
              <h2>Contact</h2>
              <p>Email: support@gamershub.com</p>
              <p>© 2025 GamersHub. All rights reserved.</p>
          </div>
      </div>
  </footer>
</body>
</html>
