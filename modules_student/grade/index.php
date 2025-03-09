<?php
include "../../db_conn.php";
$page = 'Grades';
include "../../navbar_student.php";

if (!isset($_SESSION['id'])) {
    die("Unauthorized access.");
}

$student_id = $_SESSION['id'];

// Fetch student details
$sql_student = "SELECT * FROM student WHERE id = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $student_id);
$stmt_student->execute();
$result_student = $stmt_student->get_result();
$student = $result_student->fetch_assoc();
$stmt_student->close();

$grade_level = $student['grade_level'];
$section_id = ($grade_level == 11) ? $student['grade_11'] : $student['grade_12'];

$student_name = $student['last_name'] . ', ' . $student['first_name'] . ' ' . $student['middle_name'];
$student_lrn = $student['lrn'];

// Fetch section details
$sql_section = "SELECT * FROM strand WHERE id = ?";
$stmt_section = $conn->prepare($sql_section);
$stmt_section->bind_param("i", $section_id);
$stmt_section->execute();
$result_section = $stmt_section->get_result();
$section = $result_section->fetch_assoc();
$stmt_section->close();
$section_name = $section['track'] . ' - ' . $section['name'] . ' (' . $section['details'] . ')';

// Fetch grades for both semesters
$grades_by_semester = [];

for ($semester = 1; $semester <= 2; $semester++) {
    $sql_grades = "SELECT g.subject_id, g.quarter, g.grade, g.remarks, g.semester, 
    s.code AS subject_code, s.details AS subject_details, 
    ss.type AS subject_type
FROM grades g
JOIN subject s ON g.subject_id = s.id
JOIN schedule_subject ss ON g.subject_id = ss.subject 
WHERE g.student_id = ? 
AND g.section_id = ? 
AND g.grade_level = ? 
AND g.semester = ? 
ORDER BY s.code, g.quarter";


    $stmt_grades = $conn->prepare($sql_grades);
    $stmt_grades->bind_param("iiii", $student_id, $section_id, $grade_level, $semester);
    $stmt_grades->execute();
    $result_grades = $stmt_grades->get_result();

    while ($row = $result_grades->fetch_assoc()) {
        $grades_by_semester[$semester][$row['subject_code']][] = $row;
    }
    $stmt_grades->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Grades</title>
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <style>
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
        }
        .info-box label {
            font-weight: bold;
            margin-bottom: 2px;
        }
        .info-box input {
            border: none;
            background: transparent;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="content" id="content">
        <h2 class="text-center">My Grades</h2>
        <br>
    <div class="row mb-1">
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="student_name" class="form-label m-0" style="white-space: nowrap;">Student Name:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="student_name" 
               value="<?php echo $student_name; ?>" readonly>
    </div>
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="section_name" class="form-label m-0" style="white-space: nowrap;">Section Name:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="section_name" 
               value="<?php echo $section_name; ?>" readonly>
    </div>
</div>

<div class="row mb-1">
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="student_lrn" class="form-label m-0" style="white-space: nowrap;">Student LRN:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="student_lrn" 
               value="<?php echo $student_lrn; ?>" readonly>
    </div>
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="grade_level" class="form-label m-0" style="white-space: nowrap;">Grade Level:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="grade_level" 
               value="<?php echo $grade_level; ?>" readonly>
    </div>
</div>
<br>
<hr>
<!-- Grades Tables -->
<?php foreach ([1 => "First Semester", 2 => "Second Semester"] as $semester => $semester_name): ?>
    <?php if (!empty($grades_by_semester[$semester])): ?>
        <h3 class="text-center"><?php echo strtoupper($semester_name); ?></h3>
        
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th rowspan="2">LEARNING AREAS</th>
                    <th colspan="2">QUARTER</th>
                    <th rowspan="2">FINAL GRADE</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>2</th>
                </tr>
            </thead>
            
            <!-- CORE SUBJECTS -->
            <tbody>
                <tr>
                    <th colspan="4" class="text-start">CORE SUBJECTS</th>
                </tr>
                <?php
                $total_grade = 0;
                $subject_count = 0;
                foreach ($grades_by_semester[$semester] as $subject => $entries):
                    if ($entries[0]['subject_type'] == "Core"): 
                        $quarter1 = $quarter2 = "N/A";
                        $final_average = "N/A";

                        foreach ($entries as $entry) {
                            if ($entry['quarter'] == 1) {
                                $quarter1 = $entry['grade'];
                            }
                            if ($entry['quarter'] == 2) {
                                $quarter2 = $entry['grade'];
                            }
                        }

                        if (is_numeric($quarter1) && is_numeric($quarter2)) {
                            $final_average = number_format(($quarter1 + $quarter2) / 2, 2);
                        }

                        if (is_numeric($final_average)) {
                            $total_grade += $final_average;
                            $subject_count++;
                        }
                ?>
                    <tr>
                        <td><?php echo $entries[0]['subject_code']; ?> (<?php echo $entries[0]['subject_details']; ?>)</td>
                        <td><?php echo $quarter1; ?></td>
                        <td><?php echo $quarter2; ?></td>
                        <td><?php echo $final_average; ?></td>
                    </tr>
                <?php endif; endforeach; ?>
                
                <!-- APPLIED & SPECIALIZED SUBJECTS -->
                <tr>
                    <th colspan="4" class="text-start">APPLIED AND SPECIALIZED SUBJECTS</th>
                </tr>
                <?php
                foreach ($grades_by_semester[$semester] as $subject => $entries):
                    if ($entries[0]['subject_type'] != "Core"): 
                        $quarter1 = $quarter2 = "N/A";
                        $final_average = "N/A";

                        foreach ($entries as $entry) {
                            if ($entry['quarter'] == 1) {
                                $quarter1 = $entry['grade'];
                            }
                            if ($entry['quarter'] == 2) {
                                $quarter2 = $entry['grade'];
                            }
                        }

                        if (is_numeric($quarter1) && is_numeric($quarter2)) {
                            $final_average = number_format(($quarter1 + $quarter2) / 2, 2);
                        }

                        if (is_numeric($final_average)) {
                            $total_grade += $final_average;
                            $subject_count++;
                        }
                ?>
                    <tr>
                        <td><?php echo $entries[0]['subject_code']; ?> (<?php echo $entries[0]['subject_details']; ?>)</td>
                        <td><?php echo $quarter1; ?></td>
                        <td><?php echo $quarter2; ?></td>
                        <td><?php echo $final_average; ?></td>
                    </tr>
                <?php endif; endforeach; ?>

                <!-- GENERAL AVERAGE -->
                <tr>
                    <th colspan="3" class="text-end">GENERAL AVERAGE FOR THE SEMESTER:</th>
                    <td>
                        <?php 
                        echo ($subject_count > 0) ? number_format($total_grade / $subject_count, 2) : "N/A"; 
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <hr>
    <?php else: ?>
        <h3 class="text-center"><?php echo strtoupper($semester_name); ?></h3>
        <p class="text-center text-muted">No grades available for this semester.</p>
        <br>
    <?php endif; ?>
<?php endforeach; ?>


    </div>

    <script src="../../assets/js/bootstrap5/bootstrap.bundle.min.js"></script>
</body>
</html>
