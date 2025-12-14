<?php
    include("connectToDB.php");
    
    if(isset($_POST["register"])){

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $fullname = filter_input(INPUT_POST, "fullname", FILTER_SANITIZE_SPECIAL_CHARS);
        $dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_SPECIAL_CHARS);
        $gender = filter_input(INPUT_POST, "gender", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
        $timezone = filter_input(INPUT_POST, "timezone", FILTER_SANITIZE_SPECIAL_CHARS);

        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Accounts (username, password) VALUES ('$username', '$hash')";
            mysqli_query($conn, $sql);
            $sql = "INSERT INTO Users (full_name, gender, date_of_birth, email, phone_number, time_zone)
            VALUES ('$fullname', '$gender', '$dob', '$email', '$phone', '$timezone')";        //fix default img
            mysqli_query($conn, $sql);
            echo "<script>alert('You are now registered!');</script>";
            header("Location: ../login.html");     // insert login page url here
            exit();
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('ERROR! {$e->getMessage()}');</script>"; //might be because username already taken
        }
    }
    mysqli_close($conn);
?>