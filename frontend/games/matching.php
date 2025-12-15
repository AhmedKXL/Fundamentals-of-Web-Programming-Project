<?php
    session_start();
    include("../php/connectToDB.php");
    $sql = "SELECT username, MIN(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=4 GROUP BY user_id ORDER BY MIN(score)";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Matching Game</title>
        <link rel="stylesheet" href="../styles/base.css">
        <link rel="stylesheet" href="../styles/home.css">
        <link rel="stylesheet" href="../styles/game.css">
        <link rel="stylesheet" href="./matching.css">
        <script src="./matching.js" defer></script>
    </head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="logo"><img src="../../2222222.jpg" alt="Logo" height="30px"></div>
    <nav class="nav">
      <a href="../index.php">Home</a>
      <a href="../about.html">About</a>
      <a href="../login.php" class="login">Login</a>
    </nav>
  </header>

    <!-- Game Container -->
    <div class="game-container">
        <div class="score-display">
            <div class="score your-score">
                <span>Time:</span>
                <span id="timer">0</span>
            </div>
            <button id="go-back" onclick="history.back()">&larr; Go Back</button>
        </div>

        <div class="game-area">
            <div id="game-board" class="grid"></div>
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
                <span class="player">Player 1</span>
                <span class="score">97</span>
            </div>
            <div class="leaderboard-entry">
                <span class="player">Player 2</span>
                <span class="score">83</span>
            </div>
            <div class="leaderboard-entry">
                <span class="player">Player 3</span>
                <span class="score">72</span>
            </div>
            <button id="reset" onclick="location.reload()">Reset Game</button>
        </div>
    </div>
    <button class="chatbot-button" onclick="toggleChat()">&#x1F4AC;</button>
    
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">Matching Game Bot</div>
        <div class="chat-body" id="chatBody">
            <div class="message bot">Pick a tip!</div>
        </div>
        <div class="chat-buttons">
            <button onclick="ask('s1')">Strategy 1</button>
            <button onclick="ask('s2')">Strategy 2</button>
            <button onclick="ask('f')">Fun Fact</button>
        </div>
    </div>
    
    <script>
        const answers = {
            s1: "Flip cards in a pattern to remember their positions more easily.",
            s2: "Focus on one area of the board before moving to another.",
            f: "Matching games help improve memory and concentration skills."
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