<?php
include "../../db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = intval($_POST['student_id']);
    $section_id = intval($_POST['section_id']);
    $grade_level = intval($_POST['grade_level']);
    $subject_id = intval($_POST['subject_id']);
    $semester = intval($_POST['semester']);
    $quarter = intval($_POST['quarter']);
    $grade = intval($_POST['grade']);
    $remarks = $_POST['remarks'];

    // Check if the grade already exists
    $sql_check = "SELECT id FROM grades WHERE student_id = ? AND section_id = ? AND grade_level = ? AND subject_id = ? AND semester = ? AND quarter = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("iiiiii", $student_id, $section_id, $grade_level, $subject_id, $semester, $quarter);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Update existing grade
        $sql_update = "UPDATE grades SET grade = ?, remarks = ?, updated_at = NOW() WHERE student_id = ? AND section_id = ? AND grade_level = ? AND subject_id = ? AND semester = ? AND quarter = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssiiiiii", $grade, $remarks, $student_id, $section_id, $grade_level, $subject_id, $semester, $quarter);

        if ($stmt_update->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $stmt_update->error]);
        }
        $stmt_update->close();
    } else {
        // Insert new grade
        $sql_insert = "INSERT INTO grades (student_id, section_id, grade_level, subject_id, semester, quarter, grade, remarks, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iiiiiiis", $student_id, $section_id, $grade_level, $subject_id, $semester, $quarter, $grade, $remarks);

        if ($stmt_insert->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => $stmt_insert->error]);
        }
        $stmt_insert->close();
    }

    $stmt_check->close();
    $conn->close();
}
?>
