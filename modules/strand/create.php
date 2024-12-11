<?php 

include "../../db_conn.php"; // Include your database connection

// Retrieve and sanitize form data from POST request
$strand_name = $_POST['strand_name'];
$strand_code = $_POST['strand_code'];
$teacher_id = $_POST['teacher_id'];
$track = $_POST['track'];
$details = $_POST['details'];

// Check if the teacher already exists (based on email or ID)
$check_query = mysqli_query($conn, "SELECT * FROM `strand` WHERE code = '$strand_name' AND del_status != 'deleted'");

$existing = null; 
while ($row = mysqli_fetch_array($check_query)) {
    $existing = $row['subject_name'] . " " . $row['subject_code'];
}

// If no existing teacher found, insert the new teacher
if (empty($existing)) {
    $insert_query = "INSERT INTO `strand` (
        `code`,
        `name`,
        `teacher_id`,
        `track`,
        `details`,
        `del_status`
    ) VALUES (
        '$strand_code',
        '$strand_name',
        '$teacher_id',
        '$track',
        '$details',
        'active'
    )";

    // Execute the insert query
    if (mysqli_query($conn, $insert_query)) {
        header("location:index.php?track=$track&message=Success! New Strand has been added successfully.");
    } else {
        header("location:add.php?track=$track&error=Error! Could not add the Strand.");
    }
} else {
    header("location:add.php?track=$track&error=Error! Strand already exists.");
}

?>
