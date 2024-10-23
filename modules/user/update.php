<?php

include "../../db_conn.php"; // Include the database connection

// Get the teacher ID from the URL
$id = $_GET['id'];

// Retrieve and sanitize form data
$name = $_POST['name'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];


    // Prepare SQL update statement
    $sql2 = "UPDATE `user` SET
        `name` = '$name',
        `username` = '$username',
        `password` = '$password',
        `role` = '$role'
    WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($conn, $sql2)) {
        header("location:view.php?id=$id&message=Success! User details have been updated successfully.");
    } else {
        header("location:view.php?id=$id&error=Error! Could not update the User details.");
    }

?>
