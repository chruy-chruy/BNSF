<?php
include "../../db_conn.php"; // Adjust based on your setup

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = intval($_POST['student_id']);
    $quarter = intval($_POST['quarter']);
    $grade = floatval($_POST['grade']);
    $subject_id = intval($_POST['subject_id']);
    $grade_level = intval($_POST['grade_level']);
    $section_id = intval($_POST['section_id']);
    $semester = intval($_POST['semester']);

    if ($student_id && $quarter && $grade >= 0) {
        // Check if a grade already exists
        $sql_check = "SELECT id FROM grades WHERE student_id = ? AND semester = ? AND section_id = ? AND quarter = ? AND grade_level = ? AND subject_id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("iiiiii", $student_id, $semester, $section_id, $quarter, $grade_level, $subject_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $existing_grade = $result_check->fetch_assoc(); // Fetch the existing row
        $stmt_check->close(); // Close AFTER fetching result

        if ($existing_grade) { // If a record exists, update it
            $sql_update = "UPDATE grades SET grade = ?, updated_at = NOW() WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("di", $grade, $existing_grade['id']);
            if ($stmt_update->execute()) {
                echo "Grade updated successfully!";
            } else {
                echo "Error updating grade.";
            }
            $stmt_update->close();
        } else {
            // Insert new grade record
            $sql_insert = "INSERT INTO grades (student_id, section_id, grade_level, semester, quarter, subject_id, grade, remarks, created_at, updated_at)
                           VALUES (?, ?, ?, ?, ?, ?, ?, '', NOW(), NOW())";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iiiiiid", $student_id, $section_id, $grade_level, $semester, $quarter, $subject_id, $grade);
            if ($stmt_insert->execute()) {
                echo "New grade record created!";
            } else {
                echo "Error inserting grade.";
            }
            $stmt_insert->close();
        }
    } else {
        echo "Invalid input data.";
    }
}

$conn->close();
?>
