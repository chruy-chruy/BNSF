<?php 

include "../../db_conn.php"; // Include your database connection

$id = $_GET['id']; // Get the ID from the URL

$sql = "UPDATE `strand` SET `del_status` = 'deleted' WHERE id = '$id'"; // Update the del_status to deleted
mysqli_query($conn, $sql); // Execute the query

header("location:index.php?message=Subject deleted successfully."); // Redirect back to index with a message
?>
