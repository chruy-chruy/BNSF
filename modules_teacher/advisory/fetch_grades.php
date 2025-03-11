<?php
include "../../db_conn.php";

if (!isset($_GET['semester'])) {
    die("Invalid request.");
}

$semester = intval($_GET['semester']);

// Get students
$sql_students = "SELECT id, lrn, first_name, middle_name, last_name FROM student WHERE grade_level = ? AND ((grade_11 = ? AND (grade_12 IS NULL OR grade_12 = 0)) OR grade_12 = ?)";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("iii", $grade_level, $section_id, $section_id);
$stmt_students->execute();
$result_students = $stmt_students->get_result();

// Fetch all subjects
$sql_subjects = "SELECT id FROM subject ORDER BY id ASC";
$result_subjects = $conn->query($sql_subjects);

$subjects = [];
while ($subject = $result_subjects->fetch_assoc()) {
    $subjects[] = $subject['id'];
}

// Generate the table rows dynamically
while ($student = $result_students->fetch_assoc()) {
    $student_id = $student['id'];
    $total_grade = 0;
    $num_subjects = 0;

    echo "<tr>";
    echo "<td>" . htmlspecialchars($student['lrn']) . "</td>";
    echo "<td>" . htmlspecialchars($student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name']) . "</td>";

    foreach ($subjects as $subject_id) {
        $sql_grade = "SELECT grade FROM grades WHERE student_id = ? AND subject_id = ? AND semester = ?";
        $stmt_grade = $conn->prepare($sql_grade);
        $stmt_grade->bind_param("iii", $student_id, $subject_id, $semester);
        $stmt_grade->execute();
        $result_grade = $stmt_grade->get_result();
        $grade = $result_grade->fetch_assoc()['grade'] ?? 'N/A';

        if ($grade !== 'N/A') {
            $total_grade += $grade;
            $num_subjects++;
        }

        echo "<td class='text-center'>" . htmlspecialchars($grade) . "</td>";
        $stmt_grade->close();
    }

    $average = ($num_subjects > 0) ? round($total_grade / $num_subjects, 2) : 'N/A';
    echo "<td class='bg-success text-white text-center'>$average</td>";
    echo "<td><a href='student_grade.php?student_id=$student_id' class='btn btn-primary'>View Grades</a></td>";
    echo "</tr>";
}

$conn->close();
?>
