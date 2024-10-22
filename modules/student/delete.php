<?php
include "../../db_conn.php"; // Include database connection

// Check if the student ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Set the del_status to 'deleted' instead of permanently deleting the record
    $query = "UPDATE student SET del_status = 'deleted' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        // Redirect with success message
        header("Location: index.php?message=Student deleted successfully.");
    } else {
        // Redirect with error message
        header("Location: index.php?error=Failed to delete student: " . mysqli_error($conn));
    }
} else {
    // Redirect to index if no student ID is specified
    header("Location: index.php?error=No student ID specified.");
}
?>
