<?php
// Include the database connection
include "../../db_conn.php"; // Replace with your actual DB connection file

// Check if all required parameters are set
if (isset($_GET['section'], $_GET['adviser'], $_GET['grade'], $_GET['quarter'], $_GET['sy'])) {
    
    $section = $_GET['section'];
    $adviser = $_GET['adviser'];
    $grade = $_GET['grade'];
    $quarter = $_GET['quarter'];
    $sy = $_GET['sy'];

    // Check if the adviser already has an advisory section
    $checkQuery = "SELECT * FROM schedules WHERE adviser = ?";
    if ($checkStmt = $conn->prepare($checkQuery)) {
        $checkStmt->bind_param("s", $adviser);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Adviser already has an advisory section
            $checkStmt->close();
            header("Location: schedule.php?error=Error: The teacher already has an advisory section.&track=$track&section=$section&quarter=$quarter&grade=$grade&sy=$sy");
            exit();
        }
        $checkStmt->close();
    } else {
        echo "Error preparing the SQL check query: " . $conn->error;
        exit();
    }

    // If the adviser is not assigned, update the schedule
    $updateQuery = "UPDATE schedules SET adviser = ? WHERE section = ? AND grade_level = ?";
    if ($updateStmt = $conn->prepare($updateQuery)) {
        $updateStmt->bind_param("sss", $adviser, $section, $grade);

        if ($updateStmt->execute()) {
            // Redirect back with a success message
            header("Location: schedule.php?message=Success! Adviser updated successfully.&track=$track&section=$section&quarter=$quarter&grade=$grade&sy=$sy");
            exit();
        } else {
            echo "Error updating adviser: " . $updateStmt->error;
        }
        $updateStmt->close();
    } else {
        echo "Error preparing the SQL update query: " . $conn->error;
    }

} else {
    echo "Missing required parameters.";
}
?>
