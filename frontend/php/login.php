<?php
    session_start();      // use in all html (pages)
?>
<?php
    include("connectToDB.php");
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "SELECT * FROM Accounts";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $hashedPassword = $row['password'];
            if ($row['username'] == $username && password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $row['user_id'];      //retrieve user
                header("Location: ../index.php");
                exit();
            } else {
                echo "<script>alert('Incorrect username or password!');</script>";
            }
        }
    } else {
        echo "Users table is empty!";
    }
    mysqli_close($conn);
?>
