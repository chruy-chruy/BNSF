<?php 

include "../../db_conn.php";

// Retrieve and sanitize form data
$first_name = ucwords($_POST['first_name']);
$middle_name = ucwords($_POST['middle_name']);
$last_name = ucwords($_POST['last_name']);
$sex = ($_POST['sex']);
$contact_number = ($_POST['contact_number']);
$email = ($_POST['email']);
$username = ($_POST['username']);
$password = ($_POST['password']);

// Check if teacher already exists
$squery =  mysqli_query($conn, "SELECT * FROM teacher WHERE 
    first_name = '$first_name' AND
    middle_name = '$middle_name' AND 
    last_name = '$last_name' AND 
    email = '$email' AND 
    del_status != 'deleted'");

$check = null; // Initialize check variable
while ($row = mysqli_fetch_array($squery)) {
    $check = $row['first_name'] . " " . $row['last_name'];
}

// Insert new teacher if not already exists
if (empty($check)) {
    $sql2 = "INSERT INTO `teacher` (
        `first_name`,
        `middle_name`,
        `last_name`,
        `sex`,
        `contact_number`,
        `email`,
        `username`,
        `password`,
        `del_status`
    ) VALUES (
        '$first_name',
        '$middle_name',
        '$last_name',
        '$sex',
        '$contact_number',
        '$email',
        '$username',
        '$password',
        'active')";

    if (mysqli_query($conn, $sql2)) {
        header("location:index.php?message=Success! New teacher has been added successfully.");
    } else {
        header("location:add.php?error=Error! Could not insert the teacher.");
    }
} else {
    header("location:add.php?error=Error! Teacher already exists.");
}
?>
