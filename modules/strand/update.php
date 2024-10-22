<?php

include "../../db_conn.php"; // Include the database connection

// Get the teacher ID from the URL
$id = $_GET['id'];

// Retrieve and sanitize form data
$strand_name = $_POST['strand_name'];
$strand_code = $_POST['strand_code'];
$teacher_id = $_POST['teacher_id'];


    // Prepare SQL update statement
    $sql2 = "UPDATE `strand` SET
        `code` = '$strand_code',
        `name` = '$strand_name',
        `teacher_id` = '$teacher_id'
    WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($conn, $sql2)) {
        header("location:view.php?id=$id&message=Success! Strand details have been updated successfully.");
    } else {
        header("location:view.php?id=$id&error=Error! Could not update the Strand details.");
    }

?>
