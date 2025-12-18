<?php
    session_start();
    include("../php/connectToDB.php");
    $sql = "SELECT username, MAX(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=9 GROUP BY user_id ORDER BY MAX(score)";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Simon Says</title>
        <link rel="stylesheet" href="../styles/base.css">
        <link rel="stylesheet" href="../styles/home.css">
        <link rel="stylesheet" href="../styles/game.css">
        <link rel="stylesheet" href="./simon.css">
        <script src="./simon.js" defer></script>
    </head>
<body>
  <header class="header">
    <div class="logo"></div>
    <nav class="nav">
      <a href="../index.php">Home</a>
      <a href="../about.html">About</a>
      <a href="../login.php" class="login">Login</a>
    </nav>
  </header>

    <div class="game-container">
        <div class="score-display">
            <div class="score your-score">
                <span>Level:</span>
                <span id="level-indicator">1</span>
            </div>
            <button id="go-back" onclick="history.back()">&larr; Go Back</button>
        </div>

        <div class="game-area">
            <div id="game-board">
                <div class="pad green" data-color="green"></div>
                <div class="pad red" data-color="red"></div>
                <div class="pad yellow" data-color="yellow"></div>
                <div class="pad blue" data-color="blue"></div>
            </div>
            <h3 id="status-message">Press Start to Begin</h3>
        </div>

        <div class="leaderboard-game">
            <h2>Leaderboard</h2>
            <?php 
                while($row = mysqli_fetch_assoc($result))
                    echo "<div class=\"leaderboard-entry\">
                            <span class=\"player\">{$row['username']}</span>
                            <span class=\"score\">level {$row['score']}</span>
                        </div>";
            ?>
            <button id="start-btn">Start Game</button>
        </div>
    </div>
    <button class="chatbot-button" onclick="toggleChat()">&#x1F4AC;</button>
    
    <div class="chat-window" id="chatWindow">
      <div class="chat-header">Simon Bot</div>
      <div class="chat-body" id="chatBody">
        <div class="message bot">Test your memory!</div>
      </div>
      <div class="chat-buttons">
        <button onclick="ask('m')">Memory Tip</button>
        <button onclick="ask('r')">Reaction Tip</button>
        <button onclick="ask('f')">Fun Fact</button>
      </div>
    </div>
    
    <script>
      const answers = {
        m: "Group colors into patterns to remember longer.",
        r: "Stay calm speed increases gradually.",
        f: "The original Simon game was released in 1978."
      };
      function toggleChat() { chatWindow.style.display = chatWindow.style.display === "flex" ? "none" : "flex"; }
      function ask(k) { add("user", "Tell me"); setTimeout(() => add("bot", answers[k]), 300); }
      function add(t, x) { const d = document.createElement("div"); d.className = "message " + t; d.innerText = x; chatBody.appendChild(d); }
    </script>

</body>
</html>
<?php 
    mysqli_close($conn);
?>