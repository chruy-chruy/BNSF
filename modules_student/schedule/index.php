<?php
include "../../db_conn.php";
$page = 'Schedule';
include "../../navbar_student.php";

if (!isset($_SESSION['id'])) {
    die("Unauthorized access.");
}

$student_id = $_SESSION['id'];

// Fetch student section and grade level
$sql_student = "SELECT * FROM student WHERE id = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $student_id);
$stmt_student->execute();
$result_student = $stmt_student->get_result();
$student = $result_student->fetch_assoc();
$stmt_student->close();

$grade_level = $student['grade_level'];
$section_id = ($grade_level == 11) ? $student['grade_11'] : $student['grade_12'];

$sql_section = "SELECT * FROM strand WHERE id = ?";
$stmt_section = $conn->prepare($sql_section);
$stmt_section->bind_param("i", $section_id);
$stmt_section->execute();
$result_section= $stmt_section->get_result();
$section = $result_section->fetch_assoc();
$stmt_section->close();
$section_name = $section['track'] . ' - ' . $section['name'] . ' (' . $section['details'] . ')';

$student_name = $student['last_name']. ', '.$student['first_name'] .' '.$student['middle_name'];
$student_lrn = $student['lrn'];


// First, check if semester 2 data exists
$sql_check_semester = "SELECT COUNT(*) AS count FROM schedules WHERE section = ? AND grade_level = ? AND semester = 2";
$stmt_check = $conn->prepare($sql_check_semester);
$stmt_check->bind_param("ii", $section_id, $grade_level);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row = $result_check->fetch_assoc();
$semester_2_exists = ($row && $row['count'] > 0);
$stmt_check->close();



// Fetch schedule data, prioritizing semester 2 if available
$semester_to_fetch = $semester_2_exists ? 2 : 1;
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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Schedule</title>
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <style>
    .schedule-header {
      text-align: center;
      margin-bottom: 20px;
    }
    .schedule-table th, .schedule-table td {
      text-align: center;
      vertical-align: middle;
      padding: 10px;
      font-size: 14px;
    }
    /* Make sure inputs fit well on all screen sizes */
    .form-control-sm {
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="content" id="content">
    <div class="schedule-header">
      <h2>My Schedule</h2>
    </div>

    <!-- Student Information -->
    <div class="row g-2 row-cols-1 row-cols-md-2 mb-3">
      <div class="col d-flex align-items-center gap-2">
        <label for="student_name" class="form-label m-0">Student Name:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="student_name" 
               value="<?php echo $student_name; ?>" readonly>
      </div>
      <div class="col d-flex align-items-center gap-2">
        <label for="section_name" class="form-label m-0">Section Name:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="section_name" 
               value="<?php echo $section_name; ?>" readonly>
      </div>
    </div>

    <div class="row g-2 row-cols-1 row-cols-md-2 mb-3">
      <div class="col d-flex align-items-center gap-2">
        <label for="student_lrn" class="form-label m-0">Student LRN:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="student_lrn" 
               value="<?php echo $student_lrn; ?>" readonly>
      </div>
      <div class="col d-flex align-items-center gap-2">
        <label for="grade_level" class="form-label m-0">Grade Level:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="grade_level" 
               value="<?php echo $grade_level . ' - ' . $semester_name; ?>" readonly>
      </div>
    </div>

    <!-- Responsive Table -->
    <div class="table-responsive">
      <table class="table table-bordered schedule-table">
        <thead class="table-light">
          <tr>
            <th>Time</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($schedules as $schedule): ?>
            <tr>
              <td><?= date("h:i A", strtotime($schedule['time_from'])) . ' - ' . date("h:i A", strtotime($schedule['time_to'])) ?></td>
              
              <?php 
                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
                foreach ($days as $day): 
              ?>
                <td>
                  <?= (!empty($schedule[$day]) && ($schedule[$day] == 'Lunch' || $schedule[$day] == 'Break')) 
                      ? "<strong>{$schedule[$day]}</strong>" 
                      : ($subject_map[$schedule[$day]] ?? '') ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>

  <script src="../../assets/js/bootstrap5/bootstrap.bundle.min.js"></script>
</body>
</html>
