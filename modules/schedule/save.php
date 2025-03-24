<?php
// Include the database connection
include "../../db_conn.php"; // Replace with your actual db connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $id = $_POST['id'];
    $section = $_GET['section'];
    $quarter = $_GET['quarter'];
    $track = $_GET['track'];
    $grade = $_GET['grade'];
    $sy = $_GET['sy'];
    $teacher = $_GET['teacher'];

    // Get the schedule for each day
    $monday = $_POST['schedule']['Monday'];
    $tuesday = $_POST['schedule']['Tuesday'];
    $wednesday = $_POST['schedule']['Wednesday'];
    $thursday = $_POST['schedule']['Thursday'];
    $friday = $_POST['schedule']['Friday'];

    for ($i = 0; $i < count($from); $i++) {
        $from1 = $from[$i];
        $to1 = $to[$i];

        // **Step 1: Validate Time Order (`from` must be before `to`)**
        if ($from1 >= $to1) {
            header("location:schedule.php?message=Error! 'From' time must be earlier than 'To' time.&track=$track&section=$section&quarter=$quarter&grade=$grade&sy=$sy");
            exit();
        }

        // **Step 2: Check for Overlapping Schedules in the Same Section**
        $queryId = $id[$i];
        $overlapQuery = "SELECT * FROM schedules 
                         WHERE section = ? 
                         AND id != ? 
                         AND ((time_from < ? AND time_to > ?) -- Case: Overlap inside an existing schedule
                         OR (time_from >= ? AND time_from < ?)) -- Case: Starts inside an existing schedule";
        
        $stmt = $conn->prepare($overlapQuery);
        $stmt->bind_param("sissss", $section, $queryId, $to1, $from1, $from1, $to1);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Found overlapping schedule
            header("location:schedule.php?error=Error! Schedule conflicts with an existing time in this section.&track=$track&section=$section&quarter=$quarter&grade=$grade&sy=$sy");
            exit();
        }
        $stmt->close();

        $monday1 = $monday[$i];
        $tuesday1 = $tuesday[$i];
        $wednesday1 = $wednesday[$i];
        $thursday1 = $thursday[$i];
        $friday1 = $friday[$i];

        // **Step 3: Update or Insert the Schedule**
        if ($queryId != 0) {
            $query2 = "UPDATE `schedules` SET 
                `time_from`='$from1',
                `time_to`='$to1',
                `monday`='$monday1',
                `tuesday`='$tuesday1',
                `wednesday`='$wednesday1',
                `thursday`='$thursday1',
                `friday`='$friday1',
                `semester`='$quarter',
                `adviser`='$teacher',
                `school_year`='$sy'
            WHERE id = '$queryId'";

            mysqli_query($conn, $query2);
        } else {
            $query = "INSERT INTO schedules (section, time_from, time_to, monday, tuesday, wednesday, thursday, friday, semester, school_year, grade_level, adviser) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("ssssssssssss", 
                    $section, $from1, $to1, 
                    $monday1, $tuesday1, $wednesday1, 
                    $thursday1, $friday1, 
                    $quarter, $sy, $grade, $teacher
                );

                if (!$stmt->execute()) {
                    header("location:schedule.php?message=Error inserting schedule: " . $stmt->error);
                    exit();
                }
                $stmt->close();
            } else {
                header("location:schedule.php?message=Error preparing the SQL query: " . $conn->error);
                exit();
            }
        }
    }

    header("location:schedule.php?message=Success! Schedule has been saved successfully.&track=$track&section=$section&quarter=$quarter&grade=$grade&sy=$sy");
}
?>
