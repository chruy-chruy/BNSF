<?php

include "../../db_conn.php"; // Include the database connection

// Get the teacher ID from the URL
$id = $_GET['id'];

// Retrieve and sanitize form data
$subject_name = $_POST['subject_name'];
$subject_code = $_POST['subject_code'];
$details = $_POST['details'];
$teacher_id = $_POST['teacher_id'];


    // Prepare SQL update statement
    $sql2 = "UPDATE `subject` SET
        `code` = '$subject_code',
        `name` = '$subject_name',
        `details` = '$details',
        `teacher_id` = '$teacher_id'
    WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($conn, $sql2)) {
        header("location:view.php?id=$id&message=Success! Subject details have been updated successfully.");
    } else {
        header("location:view.php?id=$id&error=Error! Could not update the Subject details.");
    }

?>
