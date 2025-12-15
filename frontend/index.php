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
            echo "<li><span>{$row['username']}</span><span>{$row['score']}</span></li>";
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
    <h4>Tic Tac Toe</h4>
    <p>
      Tic Tac Toe is one of the oldest known games, with versions found in ancient Egypt.
      When played perfectly by both players, the game will always end in a draw.
    </p>
    <br>
    <h4>Matching Game</h4>
    <p>
      Matching games are proven to improve memory and concentration skills.
      They are often used as educational tools for young children and adults alike.
    </p>
    <br>
    <h4>Connect Four</h4>
    <p>
      Connect Four has a solved strategy, meaning the first player can always win with the correct moves.
      The game was first sold in 1974 and quickly became a classic.
    </p>
    <br>
    <h4>Snake</h4>
    <p>
      The Snake game became famous after being preloaded on Nokia mobile phones in the late 1990s.
      It helped introduce millions of people to video gaming.
    </p>
    <br>
    <h4>Sliding Puzzle</h4>
    <p>
      Sliding puzzles date back to the 19th century and were once called the "15 Puzzle"
      Solving them requires logical thinking and spatial awareness.
    </p>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-section links">
        <h2>Quick Links</h2>
        <ul>
          <li><a href="index.html">Home</a></li>
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

  <!-- To Top Button -->
  <a href="#" class="to-top">&uarr;</a>

  <!-- GAME BOX SCROLL ANIMATION SCRIPT -->
  <script>
    const gameBoxes = document.querySelectorAll(".game-box");

    gameBoxes.forEach((box, index) => {
      box.style.transitionDelay = `${index * 0.15}s`;
    });

    function fadeInGames() {
      gameBoxes.forEach(box => {
        const boxTop = box.getBoundingClientRect().top;
        const triggerPoint = window.innerHeight - 100;

        if (boxTop < triggerPoint) {
          box.classList.add("inView");
        } else {
          box.classList.remove("inView");
        }
      });
    }

    window.addEventListener("scroll", fadeInGames);
    fadeInGames(); // run on load
  </script>

</body>
</html>
<?php 
  mysqli_close($conn); 
?>