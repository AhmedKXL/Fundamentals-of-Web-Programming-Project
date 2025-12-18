<?php
include("./connectToDB.php");

$game_id = intval($_GET['game_id'] ?? 1);

$sql = "
  SELECT username, MAX(score) AS score
  FROM Accounts
  NATURAL JOIN Scores
  WHERE game_id = $game_id
  GROUP BY user_id
  ORDER BY created_at DESC
  LIMIT 5;
"; // get the latest max score by each user (need another version for min scores i.e. seconds/moves)

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
  echo "<li><span>{$row['username']}</span><span>{$row['score']}</span></li>";
}

mysqli_close($conn);
