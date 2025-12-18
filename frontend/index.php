<?php
  session_start();
  include("./php/connectToDB.php");
  $images = glob("./images/*.png"); // or *.jpg if needed
  sort($images); // important: ensures stable index order
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GamersHub</title>
  <link rel="stylesheet" href="styles/home.css">
</head>
<body>

  <!-- Header -->
  <header class="header">
    <div class="logo"></div>
    <nav class="nav">
      <a href="about.html">About</a>
      <?php echo (isset($_SESSION['user_id']) ? "<a href=\"./profile.php\" class=\"login\">Profile</a>" : "") ?>
      <?php echo (isset($_SESSION['user_id']) ? "<a href=\"./php/logout.php\" class=\"login\">Logout</a>" : "<a href=\"./login.php\" class=\"login\">Login</a>") ?>
    </nav>
  </header>

  <!-- Hero with Leaderboard -->
  <section class="hero">
  <div class="carousel">
    <?php
      foreach ($images as $img) {
          $filename = basename($img);
          if (preg_match('/^(\d+)_/', $filename, $matches)) {
              $game_id = (int)$matches[1];
              ?>
              <a href="?game_id=<?= $game_id ?>"
                class="carousel-slide"
                data-game-id="<?= $game_id ?>">
                <img src="<?= $img ?>" alt="Game <?= $game_id ?>">
              </a>
              <?php
          }
      }
    ?>
    <button class="carousel-btn prev">&#10094;</button>
    <button class="carousel-btn next">&#10095;</button>
  </div>

  <div class="leaderboard">
    <h2>Latest Top Scores</h2>
    <div class="leaderboard-header">
      <span>Player</span>
      <span>Score</span>
    </div>
    <ul id="leaderboard-list">
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
    <a href="./games/2048.php" class="game-box game2048"><span class="game-box-inner">2048</span></a>
    <a href="./games/finance.php" class="game-box finance"><span class="game-box-inner">Finance!</span></a>
    <a href="./games/minesweeper.php" class="game-box minesweeper"><span class="game-box-inner">Mine Sweeper</span></a>
    <a href="./games/simon.php" class="game-box simon"><span class="game-box-inner">Simon Says</span></a>
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

  <!-- carousel script -->
  <script>
  const slides = document.querySelectorAll('.carousel-slide');
  const prev = document.querySelector('.prev');
  const next = document.querySelector('.next');
  const leaderboard = document.getElementById('leaderboard-list');

  let currentIndex = 0;

  function loadLeaderboard(game_id) {
    fetch(`./php/getLeaderboard.php?game_id=${game_id}`)
      .then(res => res.text())
      .then(html => leaderboard.innerHTML = html);
  }

  function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));

    currentIndex = index;
    const slide = slides[currentIndex];
    slide.classList.add('active');

    const game_id = slide.dataset.gameId;

    history.replaceState(null, '', '?game_id=' + game_id);
    loadLeaderboard(game_id);
  }

  prev.addEventListener('click', () => {
    showSlide((currentIndex - 1 + slides.length) % slides.length);
  });

  next.addEventListener('click', () => {
    showSlide((currentIndex + 1) % slides.length);
  });

  // 🔥 Initial load (sync with URL if present)
  const urlGameId = new URLSearchParams(window.location.search).get('game_id');

  if (urlGameId) {
    const startIndex = [...slides].findIndex(
      s => s.dataset.gameId === urlGameId
    );
    if (startIndex !== -1) currentIndex = startIndex;
  }

  showSlide(currentIndex);
</script>

</body>
</html>
<?php 
  mysqli_close($conn); 
?>