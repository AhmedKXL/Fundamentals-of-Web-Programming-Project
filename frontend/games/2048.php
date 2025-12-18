<?php
    session_start();
    include("../php/connectToDB.php");
    $sql = "SELECT username, MAX(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=6 GROUP BY user_id ORDER BY MAX(score)";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>2048</title>
        <link rel="stylesheet" href="../styles/base.css">
        <link rel="stylesheet" href="../styles/home.css">
        <link rel="stylesheet" href="../styles/game.css">
        <link rel="stylesheet" href="./2048.css">
        <script src="./2048.js" defer></script>
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
                <span>Score:</span>
                <span id="score">0</span>
            </div>
            <button id="go-back" onclick="history.back()">&larr; Go Back</button>
        </div>

        <div class="game-area">
            <div id="game-board"></div>
            <h3 id="status-message">Join the numbers to get 2048!</h3>
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
            <button id="reset">New Game</button>
        </div>
    </div>
    <button class="chatbot-button" onclick="toggleChat()">&#x1F4AC;</button>
    
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">2048 Bot</div>
        <div class="chat-body" id="chatBody">
            <div class="message bot">Need help reaching 2048?</div>
        </div>
        <div class="chat-buttons">
            <button onclick="ask('t1')">Tip</button>
            <button onclick="ask('t2')">Strategy</button>
            <button onclick="ask('f')">Fun Fact</button>
        </div>
    </div>
    
    <script>
        const answers = {
            t1: "Keep your highest tile in one corner.",
            t2: "Avoid swiping randomly plan your merges.",
            f: "2048 was created in 2014 by a 19 years old developer."
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