<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include("./connectToDB.php");

$user_id = $_SESSION['user_id'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$timezone = $_POST['timezone'];
$email = $_POST['email'];
$phone = $_POST['phone'];

// Update query
$sql = "UPDATE Users 
        SET gender='$gender', date_of_birth='$dob', time_zone='$timezone', email='$email', phone_number='$phone'
        WHERE user_id='$user_id'";
mysqli_query($conn, $sql);

// Redirect back to profile page after updating
header("Location: ../profile.php");
exit();
?>
