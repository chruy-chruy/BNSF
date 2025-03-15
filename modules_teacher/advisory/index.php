<?php
include "../../db_conn.php";
$page = 'Advisory';
include "../../navbar_teacher.php";

if (!isset($_SESSION['id'])) {
    die("Unauthorized access.");
}

$teacher_id = $_SESSION['id'];

//Fetch student section and grade level
$sql_student = "SELECT * FROM schedules WHERE adviser = ? LIMIT 1";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $teacher_id);
$stmt_student->execute();
$result_student = $stmt_student->get_result();
$student = $result_student->fetch_assoc();
$stmt_student->close();

$grade_level = $student['grade_level'];
$section_id = $student['section'];

$sql_section = "SELECT * FROM strand WHERE id = ?";
$stmt_section = $conn->prepare($sql_section);
$stmt_section->bind_param("i", $section_id);
$stmt_section->execute();
$result_section= $stmt_section->get_result();
$section = $result_section->fetch_assoc();
$stmt_section->close();
$section_name = $section['track'] . ' - ' . $section['name'] . ' (' . $section['details'] . ')';



// First, check if semester 2 data exists
$sql_check_semester = "SELECT COUNT(*) AS count FROM schedules WHERE section = ? AND grade_level = ? AND semester = 2";
$stmt_check = $conn->prepare($sql_check_semester);
$stmt_check->bind_param("ii", $section_id, $grade_level);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row = $result_check->fetch_assoc();
$semester_2_exists = ($row && $row['count'] > 0);
$stmt_check->close();



// // Fetch schedule data, prioritizing semester 2 if available
$semester_to_fetch = $_GET['semester'];
if($semester_to_fetch == 1){
  $semester_name = 'First Semester';
}else if($semester_to_fetch == 2){
  $semester_name = 'Second Semester';
};



$sql_schedule = "SELECT time_from, time_to, monday, tuesday, wednesday, thursday, friday 
                 FROM schedules 
                 WHERE section = ? AND grade_level = ? AND semester = ? 
                 ORDER BY time_from ASC";
$stmt_schedule = $conn->prepare($sql_schedule);
$stmt_schedule->bind_param("iii", $section_id, $grade_level, $semester_to_fetch);
$stmt_schedule->execute();
$result_schedule = $stmt_schedule->get_result();

// Store schedules in an array
$schedules = [];
while ($row = $result_schedule->fetch_assoc()) {
    $schedules[] = $row;
}

$stmt_schedule->close();

// Fetch all subjects and map them by ID
$sql_subjects = "SELECT id, code, details FROM subject";
$result_subjects = $conn->query($sql_subjects);

$subject_map = [];
while ($subject = $result_subjects->fetch_assoc()) {
    $subject_map[$subject['id']] = "<strong>" . htmlspecialchars($subject['code']) . "</strong>  (" . htmlspecialchars($subject['details']) . ')'; // Bold subject code
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Advisory</title>
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <style>
    .schedule-table th{
      padding: 8px;
      text-align: center;
      vertical-align: middle;
    }
    .schedule-header {
      text-align: center;
      margin-bottom: 20px;
    }
    .schedule-table td {
    text-align: left !important; /* Align text to the left */
    vertical-align: middle; /* Keep text vertically centered */
    padding: 8px; /* Add padding for better readability */
}
  </style>
</head>
<body>
  <div class="content" id="content">
    <div class="schedule-header">
      <h2>My Advisory</h2>
    </div>
    <br>
    <div class="row mb-1">
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="student_name" class="form-label m-0" style="white-space: nowrap;">Adviser Name:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="student_name" 
               value="<?php echo $teacher_creds['first_name'] . " " . $teacher_creds['last_name'] ?>" readonly>
    </div>
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="section_name" class="form-label m-0" style="white-space: nowrap;">Section Name:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="section_name" 
               value="<?php echo $section_name; ?>" readonly>
    </div>
</div>

<div class="row mb-1">
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="student_lrn" class="form-label m-0" style="white-space: nowrap;">School Year:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="student_lrn" 
               value="<?php echo $student['school_year']; ?>" readonly>
    </div>
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="grade_level" class="form-label m-0" style="white-space: nowrap;">Grade Level:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="grade_level" 
               value="<?php echo $grade_level . ' - ' . $semester_name ?>" readonly>
    </div>
</div>
<hr>


<?php
// Get students based on selected grade level and section, sorted by gender (Male first)
$sql_students = "SELECT id, lrn, first_name, middle_name, last_name, gender, age 
                 FROM student
                 WHERE grade_level = ? 
                 AND ((grade_11 = ? AND (grade_12 IS NULL OR grade_12 = 0)) OR grade_12 = ?)
                 ORDER BY gender ASC, last_name ASC, first_name ASC";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("iii", $grade_level, $section_id, $section_id);
$stmt_students->execute();
$result_students = $stmt_students->get_result();

// Fetch subjects assigned to the selected section from the schedule_subject table
$sql_subjects = "SELECT DISTINCT subject.id, subject.code FROM subject
                 JOIN schedule_subject ON subject.id = schedule_subject.subject
                 WHERE schedule_subject.section = ?
                 ORDER BY subject.id ASC";
$stmt_subjects = $conn->prepare($sql_subjects);
$stmt_subjects->bind_param("i", $section_id);
$stmt_subjects->execute();
$result_subjects = $stmt_subjects->get_result();

$subjects = [];
while ($subject = $result_subjects->fetch_assoc()) {
    $subjects[$subject['id']] = $subject['code'];
}

$selected_semester = $_GET['semester'] ?? 1;
?>

<div class="schedule-header">
    <!-- <h2>Student Grades</h2> -->
    <div class="semester-buttons">
        <a href="?semester=1" class="btn <?= $selected_semester == 1 ? 'btn-primary' : 'btn-info' ?>">Semester 1</a>
        <a href="?semester=2" class="btn <?= $selected_semester == 2 ? 'btn-primary' : 'btn-info' ?>">Semester 2</a>
    </div>
</div>

<table id="studentTable" class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Name</th>
            <?php foreach ($subjects as $subject_name) : ?>
                <th class="bg-warning text-black"><?= htmlspecialchars($subject_name) ?></th>
            <?php endforeach; ?>
            <th class="bg-success text-white" style="width:180px;">Average</th>
            <!-- <th style="width:180px;">Action</th> -->
        </tr>
    </thead>
    <tbody>
        <?php 
        $current_gender = '';
        while ($student = $result_students->fetch_assoc()) : 
            if ($student['gender'] !== $current_gender) {
                $current_gender = $student['gender'];
                echo "<tr class='table-secondary'><td colspan='100%' class='text-center'><strong>" . htmlspecialchars($current_gender) . "</strong></td></tr>";
            }
            $student_id = $student['id'];
            $total_grade = 0;
            $num_subjects = 0;
        ?>
            <tr>
                <td><?= htmlspecialchars($student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name']) ?></td>

                <?php 
                foreach ($subjects as $subject_id => $subject_name) {
                    $total_grade = 0;
                    $num_subjects = 0;
                    
                    $sql_grade = "SELECT grade FROM grades WHERE student_id = ? AND subject_id = ? AND semester = ? AND section_id = ?";
                    $stmt_grade = $conn->prepare($sql_grade);
                    $stmt_grade->bind_param("iiii", $student_id, $subject_id, $selected_semester, $section_id);
                    $stmt_grade->execute();
                    $result_grade = $stmt_grade->get_result();
                    
                    while ($row = $result_grade->fetch_assoc()) {
                        $grade_value = $row['grade'] ?? 0;
                    
                        // Ensure the grade is numeric before adding
                        if (is_numeric($grade_value) && $grade_value !== 'N/A') {
                            $total_grade += $grade_value;
                            $num_subjects++;
                        }
                    }
                    
                    $stmt_grade->close();
                    
                    // Calculate average grade
                    $grade = ($num_subjects > 0) ? ($total_grade / $num_subjects) : 0;
                    
                    // Highlight failing grades (assuming below 75 is failing)
                    $grade_class = ($grade < 75) ? 'text-danger' : '';
                    
                    echo "<td class='$grade_class'>" . htmlspecialchars(number_format($grade)) . "</td>";
                    
                }
                ?>

                <td class="bg-success text-white">
                    <?= ($num_subjects > 0) ? round($total_grade / $num_subjects, 2) : 'N/A' ?>
                </td>

                <!-- <td>
                    <a href="student_grade.php?student_id=<?= $student_id ?>" class="btn btn-primary">View Grades</a>
                </td> -->
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php $conn->close(); ?>
  </div>

  <script src="../../assets/js/bootstrap5/bootstrap.bundle.min.js"></script>
</body>
</html>
