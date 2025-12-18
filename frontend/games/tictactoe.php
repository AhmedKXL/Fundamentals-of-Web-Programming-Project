<?php
    session_start();
    include("../php/connectToDB.php");
    $sql = "SELECT username, MIN(score) as score FROM Accounts NATURAL JOIN Scores WHERE game_id=1 GROUP BY user_id ORDER BY MIN(score)";
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tic Tac Toe</title>
        <link rel="stylesheet" href="../styles/base.css">
        <link rel="stylesheet" href="../styles/home.css">
        <link rel="stylesheet" href="../styles/game.css">
        <link rel="stylesheet" href="./tictactoe.css">
        <script src="./tictactoe.js" defer></script>
    </head>
<body>
  <!-- Header -->
  <header class="header">
    <div class="logo"></div>
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
            <div id="game-board"></div>
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
        <div class="chat-header">Tic Tac Toe Bot</div>
        <div class="chat-body" id="chatBody">
            <div class="message bot">Choose a tip below!</div>
        </div>
        <div class="chat-buttons">
            <button onclick="ask('strategy1')">Strategy 1</button>
            <button onclick="ask('strategy2')">Strategy 2</button>
            <button onclick="ask('funfact')">Fun Fact</button>
        </div>
    </div>

    <script>
        const answers = {
            strategy1: "Always start in the center or a corner to maximize winning chances.",
            strategy2: "Block your opponent early to prevent forks and double threats.",
            funfact: "If both players play perfectly, Tic Tac Toe always ends in a draw."
        };

        function toggleChat() {
            const w = document.getElementById("chatWindow");
            w.style.display = w.style.display === "flex" ? "none" : "flex";
        }

        function ask(key) {
            addMsg("user", key.replace(/strategy|funfact/, "Info"));
            setTimeout(() => addMsg("bot", answers[key]), 300);
        }

        function addMsg(type, text) {
            const d = document.createElement("div");
            d.className = "message " + type;
            d.innerText = text;
            chatBody.appendChild(d);
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    </script>

</body>
</html>
<?php 
    mysqli_close($conn);
?>