<?php
    session_start();
    include("connectToDB.php");
    if (!isset($_SESSION['user_id'])) {
        exit();
    }
    if(isset($_POST["score"])){

        $user_id = $_SESSION['user_id'];
        $game_id = $_POST['game_id'];
        $score = $_POST['score'];

        try {
            $stmt = $conn->prepare("INSERT INTO Scores (user_id, game_id, score) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $user_id, $game_id, $score);
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('ERROR! {$e->getMessage()}');</script>";
        }
    }
    mysqli_close($conn);
?>