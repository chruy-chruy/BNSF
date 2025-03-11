<?php 

include "../../db_conn.php"; // Include the database connection

// Get the student ID from the URL
$subject_id = $_GET['id'];
$grade = $_GET['grade'];
$section = $_GET['section'];
$quarter = $_GET['quarter'];
$sy = $_GET['sy'];
$type = $_GET['type'];
// $track = $_GET['track'];


    // Prepare SQL update statement
    $sql2 = "INSERT INTO `schedule_subject`
    (`section`, `subject`, `type`, `semester`, `school_year`, `grade_level`) 
    VALUES ('$section','$subject_id','$type','$quarter','$sy','$grade')";

    if (mysqli_query($conn, $sql2)) {
        header("location:schedule.php?id=$id&message=Success! Subject details have been added successfully.&grade=$grade&track=$track&section=$section&quarter=$quarter&sy=$sy");
    } else {
        header("location:schedule.php?id=$id&error=Error! Could not update the Subject details.&grade=$grade&track=$track&section=$section&quarter=$quarter&sy=$sy");
    }
?>
