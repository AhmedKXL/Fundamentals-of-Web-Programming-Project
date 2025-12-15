<?php
    session_start();
    include("../php/connectToDB.php");
    $sql = "SELECT username, MAX(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=7 GROUP BY user_id ORDER BY MAX(score)";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Budget Master</title>
        <link rel="stylesheet" href="../styles/base.css">
        <link rel="stylesheet" href="../styles/home.css">
        <link rel="stylesheet" href="../styles/game.css">
        <link rel="stylesheet" href="./finance.css">
        <script src="./finance.js" defer></script>
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
                <span>Savings:</span>
                <span id="savings-display">$500</span>
                <br>
                <span>Time:</span>
                <span id="timer">60s</span>
            </div>
            <button id="go-back" onclick="history.back()">&larr; Go Back</button>
        </div>

        <div class="game-area">
            <div id="game-board"></div>
            <h3 id="status-message">Earn Income, Pay Bills, Ignore Luxuries!<br>Click on the start button on the right to begin</h3>
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
                <span class="player">SaverPro</span>
                <span class="score">$2500</span>
            </div>
            <div class="leaderboard-entry">
                <span class="player">Thrifty</span>
                <span class="score">$1800</span>
            </div>
            <button id="start-btn">Start Budgeting</button>
        </div>
    </div><button class="chatbot-button" onclick="toggleChat()">&#x1F4AC;</button>
    
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">Finance Bot</div>
        <div class="chat-body" id="chatBody">
            <div class="message bot">Want financial tips?</div>
        </div>
        <div class="chat-buttons">
            <button onclick="ask('b')">Budgeting</button>
            <button onclick="ask('i')">Investing</button>
            <button onclick="ask('f')">Fun Fact</button>
        </div>
    </div>
    
    <script>
        const answers = {
            b: "Track expenses and spend less than you earn.",
            i: "Diversifying investments reduces risk.",
            f: "Gamified finance improves long term money habits."
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