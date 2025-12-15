<?php
    session_start();
    include("../php/connectToDB.php");
    $sql = "SELECT username, MIN(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=8 GROUP BY user_id ORDER BY MIN(score)";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Minesweeper</title>
        <link rel="stylesheet" href="../styles/base.css">
        <link rel="stylesheet" href="../styles/home.css">
        <link rel="stylesheet" href="../styles/game.css">
        <link rel="stylesheet" href="./minesweeper.css">
        <script src="./minesweeper.js" defer></script>
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
                <span>Mines:</span>
                <span id="mine-count">12</span>
                <br>
                <span>Time:</span>
                <span id="timer">0</span>
            </div>
            <button id="go-back" onclick="history.back()">&larr; Go Back</button>
        </div>

        <div class="game-area">
            <div id="game-board"></div>
            <h3 id="status-message">Right Click to Flag Bombs</h3>
        </div>

        <div class="leaderboard-game">
            <h2>Leaderboard</h2>
            <?php 
                while($row = mysqli_fetch_assoc($result))
                    echo "<div class=\"leaderboard-entry\">
                            <span class=\"player\">{$row['username']}</span>
                            <span class=\"score\">{$row['score']}</span>
                        </div>";
            ?>
            <div class="leaderboard-entry">
                <span class="player">SweeperPro</span>
                <span class="score">12s</span>
            </div>
            <div class="leaderboard-entry">
                <span class="player">LuckyGuess</span>
                <span class="score">24s</span>
            </div>
            <div class="leaderboard-entry">
                <span class="player">Boom</span>
                <span class="score">31s</span>
            </div>
            <button id="reset">Reset Game</button>
        </div>
    </div>
    
    <button class="chatbot-button" onclick="toggleChat()">&#x1F4AC;</button>
    
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">Minesweeper Bot</div>
        <div class="chat-body" id="chatBody">
            <div class="message bot">Need logic help?</div>
        </div>
        <div class="chat-buttons">
            <button onclick="ask('l')">Logic Tip</button>
            <button onclick="ask('p')">Probability</button>
            <button onclick="ask('f')">Fun Fact</button>
        </div>
    </div>
    
    <script>
        const answers = {
            l: "Numbers tell how many mines touch a tile.",
            p: "If unsure, choose the square with lowest risk.",
            f: "Minesweeper taught mouse skills in early Windows."
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