<?php
// Include the database connection
include "../../db_conn.php"; // Replace with your actual db connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the 'from' and 'to' times (arrays, as you have multiple rows)
    $from = $_POST['from'];
    $to = $_POST['to'];
    $id = $_POST['id'];
    $section = $_GET['section'];
    $quarter = $_GET['quarter'];
    $track = $_GET['track'];
    $grade = $_GET['grade'];
    $sy = $_GET['sy'];
    $teacher = $_GET['teacher'];

    // Get the schedule for each day (Monday to Friday)
    $monday = $_POST['schedule']['Monday'];
    $tuesday = $_POST['schedule']['Tuesday'];
    $wednesday = $_POST['schedule']['Wednesday'];
    $thursday = $_POST['schedule']['Thursday'];
    $friday = $_POST['schedule']['Friday'];

    // Get the section (passed from the form or URL)
    
    // Loop through the data and insert each row into the database
    for ($i = 0; $i < count($from); $i++) {
        //check if the sched is already exist.
        $queryId = $id[$i];
        $from1 = $from[$i];
        $to1 = $to[$i];
        $moday1 = $monday[$i];
        $tuesday1 = $tuesday[$i];
        $wednesday1 = $wednesday[$i];
        $thursday1 = $thursday[$i];
        $friday1 = $friday[$i];

        if($queryId != 0){
            $query2 = "UPDATE `schedules` SET 
            `time_from`='$from1',
            `time_to`='$to1',
            `monday`='$moday1',
            `tuesday`='$tuesday1',
            `wednesday`='$wednesday1',
            `thursday`='$thursday1',
            `friday`='$friday1',
            `semester`='$quarter',
            `adviser`='$teacher',
            `school_year`='$sy'
             WHERE id = '$queryId'";
             
             mysqli_query($conn, $query2);
        }
        else{
        // Prepare the SQL query to insert data into the schedules table
        $query = "INSERT INTO schedules (section, time_from, time_to, monday, tuesday, wednesday, thursday, friday, semester,school_year, grade_level,adviser) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
        
        // Prepare the statement
        if ($stmt = $conn->prepare($query)) {
            // Bind the parameters
            $stmt->bind_param("ssssssssssss", 
                $section,        // Section
                $from[$i],       // From time
                $to[$i],         // To time
                $monday[$i],     // Monday
                $tuesday[$i],    // Tuesday
                $wednesday[$i],  // Wednesday
                $thursday[$i],   // Thursday
                $friday[$i],      // Friday
                $quarter,        // quarter
                $sy,        // quarter
                $grade,        // quarter
                $teacher
            );

            // Execute the statement
            if ($stmt->execute()) {
                echo "Schedule row " . ($i + 1) . " inserted successfully.<br>";
            } else {
                echo "Error inserting schedule row " . ($i + 1) . ": " . $stmt->error . "<br>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the SQL query: " . $conn->error . "<br>";
        }
    }
    }
    header("location:schedule.php?message=Success! Schedule has been saved successfully.&track=$track&section=$section&quarter=$quarter&grade=$grade&sy=$sy");
}
?>
