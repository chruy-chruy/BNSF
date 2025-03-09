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
               value="<?php echo $grade_level . ' - ' . $semester_name; ?>" readonly>
    </div>
</div>

<table class="table table-bordered schedule-table">
  <thead class="thead-light">
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

        <td>
          <?= (!empty($schedule['monday']) && ($schedule['monday'] == 'Lunch' || $schedule['monday'] == 'Break')) 
              ? "<strong>{$schedule['monday']}</strong>" 
              : ($subject_map[$schedule['monday']] ?? '') ?>
        </td>

        <td>
          <?= (!empty($schedule['tuesday']) && ($schedule['tuesday'] == 'Lunch' || $schedule['tuesday'] == 'Break')) 
              ? "<strong>{$schedule['tuesday']}</strong>" 
              : ($subject_map[$schedule['tuesday']] ?? '') ?>
        </td>

        <td>
          <?= (!empty($schedule['wednesday']) && ($schedule['wednesday'] == 'Lunch' || $schedule['wednesday'] == 'Break')) 
              ? "<strong>{$schedule['wednesday']}</strong>" 
              : ($subject_map[$schedule['wednesday']] ?? '') ?>
        </td>

        <td>
          <?= (!empty($schedule['thursday']) && ($schedule['thursday'] == 'Lunch' || $schedule['thursday'] == 'Break')) 
              ? "<strong>{$schedule['thursday']}</strong>" 
              : ($subject_map[$schedule['thursday']] ?? '') ?>
        </td>

        <td>
          <?= (!empty($schedule['friday']) && ($schedule['friday'] == 'Lunch' || $schedule['friday'] == 'Break')) 
              ? "<strong>{$schedule['friday']}</strong>" 
              : ($subject_map[$schedule['friday']] ?? '') ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<br><br>
<hr>



<!-- students -->
<?php

// Get students based on selected grade level and section

    $sql_students = "SELECT id, lrn, first_name, middle_name, last_name, gender, age 
                     FROM student
                     WHERE grade_level = ? 
                     AND ((grade_11 = ? AND (grade_12 IS NULL OR grade_12 = 0)) OR grade_12 = ?)";
    $stmt_students = $conn->prepare($sql_students);
    $stmt_students->bind_param("iii", $grade_level, $section_id, $section_id);
    $stmt_students->execute();
    $result_students = $stmt_students->get_result();

    $conn->close();

?>
<div class="schedule-header">
      <h2>My Students</h2>
    </div>
<table id="studentTable" class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>LRN</th>
              <th>Name</th>
              <th>Gender</th>
              <th>Age</th>
              <th style="width:180px;">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result_students->fetch_assoc()) : ?>
              <tr>
                <td><?= htmlspecialchars($row['lrn']) ?></td>
                <td><?= htmlspecialchars($row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['gender']) ?></td>
                <td><?= htmlspecialchars($row['age']) ?></td>

                <td>
                  <!-- Button to view grades instead of adding -->
                  <a href="student_grade.php?student_id=<?= $row['id'] ?>" class="btn btn-primary">View Grades</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
  </div>

  <script src="../../assets/js/bootstrap5/bootstrap.bundle.min.js"></script>
</body>
</html>
