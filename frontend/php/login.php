<?php
  session_start();      // use in html
?>
<?php
    include("connectToDB.php");
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Accounts";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $hashedPassword = $row['password'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $row['user_id'];      //retrieve user
                break;
            } else {
                echo "Incorrect password";
            }
        }
    } else {
        echo "Users table is empty!";
    }
    mysqli_close($conn);
?>