<?php
  session_start();
  include("./php/connectToDB.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Games Page</title>
  <link rel="stylesheet" href="styles/home.css">
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="logo"><img src="../../2222222.jpg" alt="Logo" height="30px"></div>
    <nav class="nav">
      <a href="about.html">About</a>
      <?php echo (isset($_SESSION['user_id']) ? "<a href=\"./php/logout.php\" class=\"login\">Logout</a>" : "<a href=\"./login.php\" class=\"login\">Login</a>") ?>
    </nav>
  </header>

  <!-- Hero with Leaderboard -->
  <section class="hero">
    <img src="../../2222222.jpg" alt="Car background" class="hero-bg">
    <div class="leaderboard">
      <h2>Leaderboard</h2>
      <div class="leaderboard-header">
        <span>Player</span>
        <span>Score</span>
      </div>
      <ul>
        <?php
          $sql = "SELECT username, score FROM Accounts NATURAL JOIN Scores WHERE game_id=1";   //need game id
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result))
            echo "<li><span>{$result['username']}</span><span>{$result['score']}</span></li>";
        ?>
        <li><span>Alcool69</span><span>99</span></li>
        <li><span>Alva123</span><span>80</span></li>
        <li><span>Player3</span><span>79</span></li>
        <li><span>Ahmad04</span><span>12</span></li>
        <li><span>BandieraX</span><span>5</span></li>
      </ul>
    </div>
  </section>

  <!-- Games Section -->
  <section class="games">
    <a href="./games/tictactoe.html" class="game-box tictactoe">Tic-Tac-Toe</a>
    <a href="./games/matching.html" class="game-box matching">Matching</a>
    <a href="./games/connect4.html" class="game-box connect4">Connect-4</a>
    <a href="./games/snake.html" class="game-box snake">Snake</a>
    <a href="./games/neatnine.html" class="game-box neat9">Neat Nine</a>
  </section>

  <!-- Fun Facts -->
  <section class="fun-facts">
    <h3>Fun Facts</h3>
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac hendrerit elit. 
      Curabitur vel sapien ac libero vulputate placerat. Donec vitae nunc nec enim vulputate faucibus. 
      Cras gravida, lectus at ullamcorper bibendum, elit metus euismod ante, sit amet laoreet est mi at eros.
      Suspendisse potenti. Donec vel mattis ligula.
    </p>
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

  <!-- To Top Button -->
  <a href="#" class="to-top">↑</a>

</body>
</html>
<?php 
  mysqli_close($conn); 
?>