<?php
// Check if a message or error exists in the URL parameters
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $alertType = 'success'; // Set default alert type to 'success'
} elseif (isset($_GET['error'])) {
    $message = $_GET['error'];
    $alertType = 'danger'; // Set alert type to 'danger' for errors
}
// Get the current year
$currentYear = date("Y");
// Get the next year
$nextYear = $currentYear + 1;
// Create the school year variable
$sy = "$currentYear-$nextYear";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students Module</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- Custom Style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">
</head>
<body>
<?php 
$page = 'Students';
include "../../db_conn.php";
include "../../navbar_teacher.php"; 

// Fetch schedules, join with subject table, and get section (strand) name
$sql_sections = 'SELECT DISTINCT strand.id, strand.name, schedules.grade_level, schedule_subject.subject, subject.code
                FROM schedules 
                JOIN strand ON schedules.section = strand.id
                INNER JOIN schedule_subject ON schedule_subject.section = schedules.section
                INNER JOIN subject ON schedule_subject.subject = subject.id
                WHERE subject.teacher_id = ?';

$stmt_sections = $conn->prepare($sql_sections);
$stmt_sections->bind_param("i", $teacher_id);
$stmt_sections->execute();
$result_sections = $stmt_sections->get_result();
?>

<!-- Main Content (Schedule Module) -->
<div class="content" id="content">
  <h1>Grades Module</h1>
  <!-- <p>Manage Grades here.</p> -->

    <div class="table-responsive">
      <table class="table table-bordered table-striped">
      <thead class="table-dark">
          <tr>
            <th>Subject</th>
            <th>Section Name</th>
            <th>Grade Level</th>
            <th style="width:180px;">Action</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result_sections)) { ?>
          <tr>
            <td><?= htmlspecialchars($row['code']); ?></td>
            <td><?= htmlspecialchars($row['name']); ?></td>
            <td><?= htmlspecialchars($row['grade_level']); ?></td>
            <td>
              <a href="student.php?section_id=<?= $row['id'] ?>&grade_level=<?= $row['grade_level'] ?>&subject_id=<?= $row['subject'] ?>&subject_name=<?= $row['code'] ?>"  class="btn btn-primary">
                View Students
              </a>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
  </div>
</div>
</body>
</html>
