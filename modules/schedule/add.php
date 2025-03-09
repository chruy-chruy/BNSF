<?php 

include "../../db_conn.php"; // Include the database connection

// Get the student ID from the URL
$id = $_GET['id'];
$grade = $_GET['grade'];
$section = $_GET['section'];
$quarter = $_GET['quarter'];
$sy = $_GET['sy'];
if($grade == '11'){
    $grade_level_section = 'grade_11';
}else{
    $grade_level_section = 'grade_12';
}
$track = $_GET['track'];


    // Prepare SQL update statement
    $sql2 = "UPDATE `student` SET
        $grade_level_section = '$section'
    WHERE id = '$id'";

    if (mysqli_query($conn, $sql2)) {
        header("location:schedule.php?id=$id&message=Success! Student details have been updated successfully.&grade=$grade&track=$track&section=$section&quarter=$quarter&sy=$sy");
    } else {
        header("location:schedule.php?id=$id&error=Error! Could not update the student details.&grade=$grade&track=$track&section=$section&quarter=$quarter&sy=$sy");
    }
?>
