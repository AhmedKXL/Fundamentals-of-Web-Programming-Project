<?php
    session_start();
    include("connectToDB.php");

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id, password FROM Accounts WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            header("Location: ../index.php");
            exit();
        } else {
            echo "<script>alert('Incorrect username or password!'); window.location.href = '../login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href = '../login.php';</script>";
    }

    $stmt->close();
    $conn->close();
?>
