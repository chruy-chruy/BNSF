<?php 

include "../../db_conn.php"; // Include your database connection

// Retrieve and sanitize form data from POST request
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];


// Check if the teacher already exists (based on email or ID)
$check_query = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username' AND `role` = '$role'");

$existing = null; 
while ($row = mysqli_fetch_array($check_query)) {
    $existing = $row['username'] . " " . $row['role'];
}

// If no existing teacher found, insert the new teacher
if (empty($existing)) {
    $insert_query = "INSERT INTO `user` (
        `name`,
        `username`,
        `password`,
        `role`
    ) VALUES (
        '$name',
        '$username',
        '$password',
        '$role'
    )";

    // Execute the insert query
    if (mysqli_query($conn, $insert_query)) {
        header("location:index.php?message=Success! New User has been added successfully.");
    } else {
        header("location:add.php?error=Error! Could not add the User.");
    }
} else {
    header("location:add.php?error=Error! User already exists.");
}

?>
