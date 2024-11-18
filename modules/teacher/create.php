<?php 

include "../../db_conn.php"; // Include your database connection

// Retrieve and sanitize form data from POST request
$id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
$last_name = ucwords(mysqli_real_escape_string($conn, $_POST['last_name']));
$middle_name = ucwords(mysqli_real_escape_string($conn, $_POST['middle_name']));
$first_name = ucwords(mysqli_real_escape_string($conn, $_POST['first_name']));
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
// $age = mysqli_real_escape_string($conn, $_POST['age']);
// $nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
$birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if the teacher already exists (based on email or ID)
$check_query = mysqli_query($conn, "SELECT * FROM teacher WHERE id_number = '$id_number' OR email = '$email' AND del_status != 'deleted'");

$existing = null; 
while ($row = mysqli_fetch_array($check_query)) {
    $existing = $row['id_number'] . " " . $row['email'];
}

// If no existing teacher found, insert the new teacher
if (empty($existing)) {
    $insert_query = "INSERT INTO `teacher` (
        `id_number`,
        `last_name`,
        `middle_name`,
        `first_name`,
        `gender`,
        `birthday`,
        `address`,
        `contact`,
        `email`,
        `username`,
        `password`,
        `del_status`
    ) VALUES (
        '$id_number',
        '$last_name',
        '$middle_name',
        '$first_name',
        '$gender',
        '$birthday',
        '$address',
        '$contact',
        '$email',
        '$username',
        '$password',
        'active'
    )";

    // Execute the insert query
    if (mysqli_query($conn, $insert_query)) {
        header("location:index.php?message=Success! New teacher has been added successfully.");
    } else {
        header("location:add.php?error=Error! Could not add the teacher.");
    }
} else {
    header("location:add.php?error=Error! Teacher already exists.");
}

?>
