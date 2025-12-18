<?php
    session_start();
    include("../php/connectToDB.php");
    $sql = "SELECT username, MAX(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=2 GROUP BY user_id ORDER BY MAX(score) DESC";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Snake</title>
        <link rel="stylesheet" href="../styles/base.css">
        <link rel="stylesheet" href="../styles/home.css">
        <link rel="stylesheet" href="../styles/game.css">
        <link rel="stylesheet" href="./snake.css">
        <script src="./snake.js" defer></script>
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
            <h3 id="status-message">Press Arrow Keys to Start</h3>
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
            <button id="reset" onclick="location.reload()">Reset Game</button>
        </div>
    </div>
    <button class="chatbot-button" onclick="toggleChat()">&#x1F4AC;</button>
    
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">Snake Bot</div>
        <div class="chat-body" id="chatBody">
            <div class="message bot">Need tips?</div>
        </div>
        <div class="chat-buttons">
            <button onclick="ask('s1')">Strategy 1</button>
            <button onclick="ask('s2')">Strategy 2</button>
            <button onclick="ask('f')">Fun Fact</button>
        </div>
    </div>
    
    <script>
        const answers = {
            s1: "Avoid corners unless you have a clear escape path.",
            s2: "Plan your movement ahead to avoid trapping yourself.",
            f: "Snake became famous after being preinstalled on Nokia phones."
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