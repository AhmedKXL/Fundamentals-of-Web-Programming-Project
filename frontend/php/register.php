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

        $conn->begin_transaction();
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // insert into Accounts
            $stmt1 = $conn->prepare("INSERT INTO Accounts (username, password) VALUES (?, ?)");
            $stmt1->bind_param("ss", $username, $hash);
            $stmt1->execute();

            // Get the last inserted user_id
            $user_id = $conn->insert_id; 
            $stmt1->close();

            // Insert into Users with the correct foreign key
            $stmt2 = $conn->prepare("INSERT INTO Users (user_id, full_name, gender, date_of_birth, email, phone_number, time_zone)
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param("issssss", $user_id, $fullname, $gender, $dob, $email, $phone, $timezone);
            $stmt2->execute();
            $stmt2->close();

            $conn->commit();
            echo "<script>alert('You are now registered!'); window.location.href = '../login.php';</script>";     // insert login page url here
        } catch (mysqli_sql_exception $e) {
            $conn->rollback(); // undo any partial inserts
            if ($e->getCode() == 1062)
                echo "<script>alert('ERROR! User name already taken!'); window.location.href = '../register.html';</script>"; //might be because username already taken
            else
                echo "<script>alert('ERROR! {$e->getMessage()}');</script>";
        }
    }
    mysqli_close($conn);
?>