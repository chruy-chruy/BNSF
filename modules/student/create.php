<?php 

include "../../db_conn.php"; // Include the database connection

// Retrieve and sanitize form data
$lrn = mysqli_real_escape_string($conn, $_POST['lrn']);
$first_name = ucwords(mysqli_real_escape_string($conn, $_POST['first_name']));
$middle_name = ucwords(mysqli_real_escape_string($conn, $_POST['middle_name']));
$last_name = ucwords(mysqli_real_escape_string($conn, $_POST['last_name']));
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$age = mysqli_real_escape_string($conn, $_POST['age']);
$nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
$birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$mothers_name = ucwords(mysqli_real_escape_string($conn, $_POST['mothers_name']));
$mothers_occupation = ucwords(mysqli_real_escape_string($conn, $_POST['mothers_occupation']));
$fathers_name = ucwords(mysqli_real_escape_string($conn, $_POST['fathers_name']));
$fathers_occupation = ucwords(mysqli_real_escape_string($conn, $_POST['fathers_occupation']));
$strand = mysqli_real_escape_string($conn, $_POST['strand']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

// Check if the student already exists
$squery = mysqli_query($conn, "SELECT * FROM student WHERE 
    lrn = '$lrn' OR
    email = '$email' AND 
    del_status != 'deleted'");

$check = null; // Initialize check variable
while ($row = mysqli_fetch_array($squery)) {
    $check = $row['lrn'] . " " . $row['email'];
}

// Insert new student if not already exists
if (empty($check)) {
    // Prepare SQL insert statement
    $sql2 = "INSERT INTO `student` (
        `lrn`,
        `first_name`,
        `middle_name`,
        `last_name`,
        `gender`,
        `age`,
        `nationality`,
        `birthday`,
        `address`,
        `contact`,
        `email`,
        `mothers_name`,
        `mothers_occupation`,
        `fathers_name`,
        `fathers_occupation`,
        `strand`,
        `username`,
        `password`,
        `del_status`
    ) VALUES (
        '$lrn',
        '$first_name',
        '$middle_name',
        '$last_name',
        '$gender',
        '$age',
        '$nationality',
        '$birthday',
        '$address',
        '$contact',
        '$email',
        '$mothers_name',
        '$mothers_occupation',
        '$fathers_name',
        '$fathers_occupation',
        '$strand',
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
