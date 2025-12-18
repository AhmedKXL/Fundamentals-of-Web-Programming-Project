<?php
    session_start();
    include("../php/connectToDB.php");
    $sql = "SELECT username, MIN(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=5 GROUP BY user_id ORDER BY MIN(score)";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Connect 4 vs Bot</title>
        <link rel="stylesheet" href="../styles/base.css">
        <link rel="stylesheet" href="../styles/home.css">
        <link rel="stylesheet" href="../styles/game.css">
        <link rel="stylesheet" href="./connect4.css">
        <script src="./connect4.js" defer></script>
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
                <span>Turn:</span>
                <span id="current-player" class="player-red">You (Red)</span>
                <br>
                <span>Time:</span>
                <span id="timer">0</span>
            </div>
            <button id="go-back" onclick="history.back()">&larr; Go Back</button>
        </div>

        <div class="game-area">
            <div id="game-board"></div>
            <h3 id="status-message"></h3>
        </div>

        <div class="leaderboard-game">
            <h2>Leaderboard</h2>
            <?php 
                while($row = mysqli_fetch_assoc($result))
                    echo "<div class=\"leaderboard-entry\">
                            <span class=\"player\">{$row['username']}</span>
                            <span class=\"score\">{$row['score']} sec</span>
                        </div>";
            ?>
            <button id="reset" onclick="location.reload()">Reset Game</button>
        </div>
    </div>
    <button class="chatbot-button" onclick="toggleChat()">&#x1F4AC;</button>
    
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">Connect Four Bot</div>
        <div class="chat-body" id="chatBody">
            <div class="message bot">Choose a tip!</div>
        </div>
        <div class="chat-buttons">
            <button onclick="ask('s1')">Strategy 1</button>
            <button onclick="ask('s2')">Strategy 2</button>
            <button onclick="ask('f')">Fun Fact</button>
        </div>
    </div>
    
    <script>
        const answers = {
            s1: "Control the center columns to create more winning opportunities.",
            s2: "Always think ahead and block your opponent's potential connections.",
            f: "Connect Four is a solved game, the first player can always win with perfect play."
        };

        function toggleChat() { chatWindow.style.display = chatWindow.style.display === "flex" ? "none" : "flex"; }
        function ask(k) { add("user", "Tell me"); setTimeout(() => add("bot", answers[k]), 300); }
        function add(t, x) { const d = document.createElement("div"); d.className = "message " + t; d.innerText = x; chatBody.appendChild(d); chatBody.scrollTop = chatBody.scrollHeight; }
    </script>

</body>
</html>
<?php 
    mysqli_close($conn);
?>