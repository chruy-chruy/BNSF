<?php

include "../../db_conn.php"; // Include the database connection

// Get the teacher ID from the URL
$id = $_GET['id'];

// Retrieve and sanitize form data
$id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
$first_name = ucwords(mysqli_real_escape_string($conn, $_POST['first_name']));
$middle_name = ucwords(mysqli_real_escape_string($conn, $_POST['middle_name']));
$last_name = ucwords(mysqli_real_escape_string($conn, $_POST['last_name']));
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
// $age = mysqli_real_escape_string($conn, $_POST['age']);
// $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
$birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if another teacher with the same ID number or email already exists (excluding the current teacher)
$squery = mysqli_query($conn, "SELECT * FROM teacher WHERE 
    (id_number = '$id_number' OR email = '$email') AND 
    id != '$id' AND 
    del_status != 'deleted'");

$check = null; // Initialize check variable
while ($row = mysqli_fetch_array($squery)) {
    $check = $row['id_number'] . " " . $row['email'];
}

// Update teacher details if no conflict
if (empty($check)) {
    // Prepare SQL update statement
    $sql2 = "UPDATE `teacher` SET
        `id_number` = '$id_number',
        `first_name` = '$first_name',
        `middle_name` = '$middle_name',
        `last_name` = '$last_name',
        `gender` = '$gender',
        `birthday` = '$birthday',
        `address` = '$address',
        `contact` = '$contact',
        `email` = '$email',
        `username` = '$username',
        `password` = '$password'
    WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($conn, $sql2)) {
        header("location:view.php?id=$id&message=Success! Teacher details have been updated successfully.");
    } else {
        header("location:view.php?id=$id&error=Error! Could not update the teacher details.");
    }
} else {
    header("location:view.php?id=$id&error=Error! Another teacher with the same ID number or email already exists.");
}
?>
