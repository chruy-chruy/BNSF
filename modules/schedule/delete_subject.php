<?php 

include "../../db_conn.php"; // Include your database connection

$id = $_GET['id']; // Get the ID from the URL
$section = $_GET['section'];
$quarter = $_GET['quarter'];
$track = $_GET['track'];
$grade = $_GET['grade'];
$sy = $_GET['sy'];


$sql = "DELETE FROM `schedule_subject` WHERE id = '$id'"; // Update the del_status to deleted
mysqli_query($conn, $sql); // Execute the query

header("location:schedule.php?message=Subject deleted successfully.&track=$track&section=$section&quarter=$quarter&grade=$grade&sy=$sy"); // Redirect back to index with a message
?>
