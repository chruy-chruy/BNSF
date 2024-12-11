<?php 

include "../../db_conn.php"; // Include the database connection

// Get the student ID from the URL
$id = $_GET['id'];

// Retrieve and sanitize form data
$lrn = mysqli_real_escape_string($conn, $_POST['lrn']);
$first_name = ucwords(mysqli_real_escape_string($conn, $_POST['first_name']));
$middle_name = ucwords(mysqli_real_escape_string($conn, $_POST['middle_name']));
$last_name = ucwords(mysqli_real_escape_string($conn, $_POST['last_name']));
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$nationality = mysqli_real_escape_string($conn, $_POST['nationality']);
$birthday = $_POST['birthday']; // Assuming format: YYYY-MM-DD
$birthdate2 = new DateTime($birthday); // Convert to DateTime
$currentDate = new DateTime(); // Get the current date
$age = $currentDate->diff($birthdate2)->y; // Calculate the age in years
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
$grade_level = mysqli_real_escape_string($conn, $_POST['grade_level']);

// Check if another student with the same LRN or email already exists (excluding the current student)
$squery = mysqli_query($conn, "SELECT * FROM student WHERE 
    (lrn = '$lrn' OR email = '$email') AND 
    id != '$id' AND 
    del_status != 'deleted'");

$check = null; // Initialize check variable
while ($row = mysqli_fetch_array($squery)) {
    $check = $row['lrn'] . " " . $row['email'];
}

// Update student details if no conflict
if (empty($check)) {
    // Prepare SQL update statement
    $sql2 = "UPDATE `student` SET
        `lrn` = '$lrn',
        `first_name` = '$first_name',
        `middle_name` = '$middle_name',
        `last_name` = '$last_name',
        `gender` = '$gender',
        `age` = '$age',
        `nationality` = '$nationality',
        `birthday` = '$birthday',
        `address` = '$address',
        `contact` = '$contact',
        `email` = '$email',
        `mothers_name` = '$mothers_name',
        `mothers_occupation` = '$mothers_occupation',
        `fathers_name` = '$fathers_name',
        `fathers_occupation` = '$fathers_occupation',
        `strand` = '$strand',
        `username` = '$username',
        `grade_level` = '$grade_level',
        `password` = '$password'
    WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($conn, $sql2)) {
        header("location:view.php?id=$id&message=Success! Student details have been updated successfully.&grade=$grade_level");
    } else {
        header("location:view.php?id=$id&error=Error! Could not update the student details.&grade=$grade_level");
    }
} else {
    header("location:view.php?id=$id&error=Error! Another student with the same LRN or email already exists.&grade=$grade_level");
}
?>
