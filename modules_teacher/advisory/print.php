<?php
include "../../db_conn.php";

$student_id = $_GET['student_id'];

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
    <title>Print Report Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            display: flex;
            flex-direction: row;
            font-size: 12px;
        }
        .column {
            width: 50%;
            /* padding-right: 50px; */
        }
        .column1 {
            width: 50%;
            padding-right: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .section-title {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
        }
        @media print {
               @page {
        size: A4 landscape;
         margin: 10mm; 
    }
            body {
                margin: 0;
                display: flex;
                flex-direction: row;
            }
            .text-start {
    text-align: left;
    padding-left: 5px; /* Optional: Adds spacing for better alignment */
}
            
        }

    </style>
</head>
<body>
    <div class="column1">
        <h2 class="section-title">Report on Learning Progress and Achievement</h2>
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
                    <th colspan="4" class="text-start"  style="background-color:rgb(179, 179, 230);">CORE SUBJECTS</th>
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
                        <td class="text-start" ><?php echo $entries[0]['subject_code']; ?> (<?php echo $entries[0]['subject_details']; ?>)</td>
                        <td><?php echo $quarter1; ?></td>
                        <td><?php echo $quarter2; ?></td>
                        <td><?php echo $final_average; ?></td>
                    </tr>
                <?php endif; endforeach; ?>
                
                <!-- APPLIED & SPECIALIZED SUBJECTS -->
                <tr>
                    <th colspan="4" class="text-start" style="background-color:rgb(179, 179, 230);">APPLIED AND SPECIALIZED SUBJECTS</th>
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
                        <td class="text-start" ><?php echo $entries[0]['subject_code']; ?> (<?php echo $entries[0]['subject_details']; ?>)</td>
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
    <?php else: ?>
        <h3 class="text-center"><?php echo strtoupper($semester_name); ?></h3>
        <p class="text-center text-muted">No grades available for this semester.</p>
        <br>
    <?php endif; ?>
<?php endforeach; ?>

    </div>

    <div class="column">
        <h2 class="section-title">Report on Learner's Observed Values</h2>
        <table>
            <tr>
                <th>Core Values</th>
                <th>Behavior Statements</th>
                <th>Q1</th>
                <th>Q2</th>
                <th>Q3</th>
                <th>Q4</th>
            </tr>
            <tr>
                <td style="height:100px;" >Maka-Diyos</td>
                <td style="width: 120px;">Expresses one's spiritual beliefs while respecting others</td>
                <td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td style="height:100px;" >Makatao</td>
                <td>Is sensitive to individual, social, and cultural differences</td>
                <td></td><td></td><td></td><td></td>
            </tr>
            <tr>
                <td style="height:100px;" >Makabansa</td>
                <td>Demonstrates pride in being a Filipino</td>
                <td></td><td></td><td></td><td></td>
            </tr>
        </table>
        <br><br>
        <h2 class="section-title">Learning Progress and Achievement</h2>
        <table>
            <tr>
                <th>Descriptors</th>
                <th>Grading Scale</th>
                <th>Remarks</th>
            </tr>
            <tr>
                <td>Outstanding</td>
                <td>90 - 100</td>
                <td>Passed</td>
            </tr>
            <tr>
                <td>Very Satisfactory</td>
                <td>85 - 89</td>
                <td>Passed</td>
            </tr>
            <tr>
                <td>Satisfactory</td>
                <td>80 - 84</td>
                <td>Passed</td>
            </tr>
            <tr>
                <td>Fairly Satisfactory</td>
                <td>75 - 79</td>
                <td>Passed</td>
            </tr>
            <tr>
                <td>Did Not Meet Expectations</td>
                <td>Below 75</td>
                <td>Failed</td>
            </tr>
        </table>
    </div>
</body>
</html>
<script>
    window.onload = function() {
        window.print();
        setTimeout(function() {
            window.close(); // Automatically close the tab after printing
        }, 1000);
    };
</script>