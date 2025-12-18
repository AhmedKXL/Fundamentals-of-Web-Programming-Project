<?php
  session_start();
  if(isset($_SESSION['user_id']))
    header("Location: ./index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="./styles/login.css">
    <script src="./js/login.js"></script>
</head>
<body>
    <form class="login-container" action="./php/login.php" method="POST">
        <h1 class="login-title">Login</h1>
        
        <label class="label username-label" for="username">Username</label>
        <input type="text" id="username" name="username" class="username-field" placeholder="Enter your username" required>
        
        <label class="label password-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="password-field" placeholder="Enter your password" required>
        
        <button type="submit" class="login-button">Login</button>
        <p class="register-text">Don't have an account? <a href="./register.html">Register</a></p>
    </form>
</body>
</html>
