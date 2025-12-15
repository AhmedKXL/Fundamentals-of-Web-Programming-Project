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
          $sql = "SELECT username, MAX(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=2 GROUP BY user_id ORDER BY MAX(score)";   //need game id
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
    <a href="./games/tictactoe.php" class="game-box tictactoe"><span class="game-box-inner">Tic-Tac-Toe</span></a>
    <a href="./games/matching.php" class="game-box matching"><span class="game-box-inner">Matching</span></a>
    <a href="./games/connect4.php" class="game-box connect4"><span class="game-box-inner">Connect-4</span></a>
    <a href="./games/snake.php" class="game-box snake"><span class="game-box-inner">Snake</span></a>
    <a href="./games/neatnine.php" class="game-box neat9"><span class="game-box-inner">Neat Nine</span></a>
    <a href="./games/2048.php" class="game-box snake"><span class="game-box-inner">2048</span></a> <!-- change snake with game name class -->
    <a href="./games/finance.php" class="game-box snake"><span class="game-box-inner">Finance!</span></a>
    <a href="./games/minesweeper.php" class="game-box snake"><span class="game-box-inner">Mine Sweeper</span></a>
    <a href="./games/simon.php" class="game-box snake"><span class="game-box-inner">Simon Says</span></a>
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

    <h4>Neat Nine</h4>
    <p>
      Neat Nine is a strategy-based number game that challenges players to think ahead and plan efficiently.
      Games like this improve logical reasoning and pattern recognition skills.
    </p>
    <br>

    <h4>2048</h4>
    <p>
      2048 was created by a 19-year-old developer in just one weekend.
      The game went viral worldwide and inspired countless variations and clones.
    </p>
    <br>

    <h4>Finance!</h4>
    <p>
      Finance-based games help players understand budgeting, investing, and risk management in a fun way.
      Studies show that gamified learning improves long-term financial literacy.
    </p>
    <br>

    <h4>Minesweeper</h4>
    <p>
      Minesweeper was included with early versions of Windows to help users learn mouse control.
      Despite its simple look, the game requires deep logical thinking and probability skills.
    </p>
    <br>

    <h4>Simon Says</h4>
    <p>
      Simon Says tests memory, reaction time, and focus by challenging players to repeat growing patterns.
      The original electronic Simon game was released in 1978 and became an instant hit.
    </p>
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