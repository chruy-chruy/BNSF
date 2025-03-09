<?php 

include "../../db_conn.php"; // Include your database connection

// Retrieve and sanitize form data from POST request
$subject_name = $_POST['subject_name'];
$subject_code = $_POST['subject_code'];
$details = $_POST['details'];
$teacher_id = $_POST['teacher_id'];
$grade_level = $_POST['grade_level'];

// Check if the teacher and subject already exists (based on email or ID)
$check_query = mysqli_query($conn, "SELECT * FROM `subject` WHERE code = '$subject_code' AND `teacher_id` = '$teacher_id' AND del_status != 'deleted'");

$existing = null; 
while ($row = mysqli_fetch_array($check_query)) {
    $existing = $row['subject_name'] . " " . $row['subject_code'];
}

// If no existing teacher found, insert the new teacher
if (empty($existing)) {
    $insert_query = "INSERT INTO `subject` (
        `code`,
        `name`,
        `details`,
        `teacher_id`,
        `grade_level`,
        `del_status`
    ) VALUES (
        '$subject_code',
        '$subject_name',
        '$details',
        '$teacher_id',
        '$grade_level',
        'active'
    )";

    // Execute the insert query
    if (mysqli_query($conn, $insert_query)) {
        header("location:subject.php?grade=$grade_level&message=Success! New Subject has been added successfully.");
    } else {
        header("location:add.php?grade=$grade_level&error=Error! Could not add the Subject.");
    }
} else {
    header("location:add.php?grade=$grade_level&error=Error! Subject already exists.");
}

?>
