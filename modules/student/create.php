<?php 

include "../../db_conn.php"; // Include the database connection

// Retrieve and sanitize form data
$lrn = mysqli_real_escape_string($conn, $_POST['lrn']);
$first_name = ucwords(mysqli_real_escape_string($conn, $_POST['first_name']));
$middle_name = ucwords(mysqli_real_escape_string($conn, $_POST['middle_name']));
$last_name = ucwords(mysqli_real_escape_string($conn, $_POST['last_name']));
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
// $age = mysqli_real_escape_string($conn, $_POST['age']);
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
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$grade_level = mysqli_real_escape_string($conn, $_POST['grade_level']);
$password = mysqli_real_escape_string($conn, $_POST['password']);


// Check if the student already exists
$squery = mysqli_query($conn, "SELECT * FROM student WHERE 
    lrn = '$lrn' AND
    email = '$email' AND 
    grade_level = $grade_level AND
    del_status != 'deleted'");

$check = null; // Initialize check variable
while ($row = mysqli_fetch_array($squery)) {
    $check = $row['lrn'] . " " . $row['email'];
}

// Insert new student if not already exists
if (empty($check)) {
    //check if it has already records
    if (isset($_GET['student'])){ 
        $student_id = $_GET['student'];
        // Prepare SQL update statement
    $sql1 = "UPDATE `student` SET
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
    `username` = '$username',
    `grade_level` = '$grade_level',
    `password` = '$password'
WHERE id = '$student_id'";

// Execute the query
if (mysqli_query($conn, $sql1)) {
    header("location:view.php?id=$student_id&message=Success! Student details have been updated successfully.&grade=$grade_level");
} else {
    header("location:view.php?id=$student_id&error=Error! Could not update the student details.&grade=$grade_level");
}

    }else{
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
        `username`,
        `password`,
        `grade_level`,
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
        '$username',
        '$password',
        '$grade_level',
        'active')";

    // Execute the query
    if (mysqli_query($conn, $sql2)) {
        header("location:student.php?message=Success! New student has been added successfully.&grade=$grade_level");
    } else {
        header("location:add.php?error=Error! Could not insert the student.&grade=$grade_level");
    }
}
} else {
    header("location:add.php?error=Error! Student already exists.&grade=$grade_level");
}
?>
