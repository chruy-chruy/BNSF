<?php 

include "../../db_conn.php"; // Include the database connection

// Retrieve and sanitize form data
$first_name = ucwords(mysqli_real_escape_string($conn, $_POST['first_name']));
$middle_name = ucwords(mysqli_real_escape_string($conn, $_POST['middle_name']));
$last_name = ucwords(mysqli_real_escape_string($conn, $_POST['last_name']));
$sex = mysqli_real_escape_string($conn, $_POST['sex']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$grade_level = mysqli_real_escape_string($conn, $_POST['grade_level']);
$strand = mysqli_real_escape_string($conn, $_POST['strand']);
$section = mysqli_real_escape_string($conn, $_POST['section']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if the student already exists
$squery = mysqli_query($conn, "SELECT * FROM student WHERE 
    first_name = '$first_name' AND
    middle_name = '$middle_name' AND 
    last_name = '$last_name' AND 
    email = '$email' AND 
    del_status != 'deleted'");

$check = null; // Initialize check variable
while ($row = mysqli_fetch_array($squery)) {
    $check = $row['first_name'] . " " . $row['last_name'];
}

// Insert new student if not already exists
if (empty($check)) {
    // Prepare SQL insert statement
    $sql2 = "INSERT INTO `student` (
        `first_name`,
        `middle_name`,
        `last_name`,
        `sex`,
        `address`,
        `contact_number`,
        `email`,
        `grade_level`,
        `strand`,
        `section`,
        `username`,
        `password`,
        `del_status`
    ) VALUES (
        '$first_name',
        '$middle_name',
        '$last_name',
        '$sex',
        '$address',
        '$contact_number',
        '$email',
        '$grade_level',
        '$strand',
        '$section',
        '$username',
        '$password',
        'active')";

    // Execute the query
    if (mysqli_query($conn, $sql2)) {
        header("location:index.php?message=Success! New student has been added successfully.");
    } else {
        header("location:add.php?error=Error! Could not insert the student.");
    }
} else {
    header("location:add.php?error=Error! Student already exists.");
}
?>
