<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaderboard Games Page</title>
  <link rel="stylesheet" href="styles/home.css">
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="logo"><img src="../../2222222.jpg" alt="Logo" height="30px"></div>
    <nav class="nav">
      <a href="index.html">Home</a>
      <a href="about.html">About</a>
      <?php echo (isset($_SESSION['user_id']) ? "Logout" : "<a href=\"login.html\" class=\"login\">Login</a>") ?>
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
    <div class="game-box">Game</div>
    <div class="game-box">Game</div>
    <div class="game-box">Game</div>
    <div class="game-box">Game</div>
    <div class="game-box">Game</div>
    <div class="game-box">Game</div>
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
