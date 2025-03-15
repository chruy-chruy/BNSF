<?php
// Check if a message or error exists in the URL parameters
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $alertType = 'success'; // Set default alert type to 'success'
} elseif (isset($_GET['error'])) {
    $message = $_GET['error'];
    $alertType = 'danger'; // Set alert type to 'danger' for errors
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subject Module</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- Custom Style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">
  <style>
    /* Box button design */
    .btn-box {
      display: block;
      width: 200px; /* Fixed width for all buttons */
      padding: 15px 0; /* Consistent padding */
      font-size: 18px; /* Font size */
      text-align: center; /* Center the text */
      border: 2px solid #007bff; /* Border for box design */
      border-radius: 8px; /* Rounded corners */
      transition: all 0.3s ease; /* Smooth transition for hover effect */
    }

    /* Button color */
    .btn-tvl {
      background-color: #28a745;
      color: white;
    }

    .btn-academic {
      background-color: #007bff;
      color: white;
    }

    /* Hover effect */
    .btn-box:hover {
      transform: scale(1.05); /* Slightly scale up on hover */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Add shadow on hover */
    }
  </style>
</head>
<body>
<?php 
$page = 'Students';
include "../../db_conn.php";
include "../../navbar_teacher.php"; 

// Fetch schedules, join with subject table, and get section (strand) name
$sql_sections = 'SELECT DISTINCT strand.id, strand.name, schedule_subject.grade_level, schedule_subject.subject, subject.code
                FROM schedules 
                JOIN strand ON schedules.section = strand.id
                INNER JOIN schedule_subject ON schedule_subject.section = schedules.section
                INNER JOIN subject ON schedule_subject.subject = subject.id
                WHERE subject.teacher_id = ?
                ORDER BY schedule_subject.grade_level asc';

$stmt_sections = $conn->prepare($sql_sections);
$stmt_sections->bind_param("i", $teacher_id);
$stmt_sections->execute();
$result_sections = $stmt_sections->get_result();
?>


<!-- Main Content (Schedule Module) -->
<div class="content" id="content">
  <h1>Grade Module</h1>


  <!-- Schedule Module -->
  <div id="scheduleSection" class="d-flex justify-content-center align-items-center" style="height: 50vh;">
    <div class="text-center">
      <!-- Button Container -->
      <div class="d-flex justify-content-center gap-4">
      <?php while ($row = mysqli_fetch_assoc($result_sections)) { ?>
        <a href="student.php?section_id=<?= $row['id'] ?>&grade_level=<?= $row['grade_level'] ?>&subject_id=<?= $row['subject'] ?>&subject_name=<?= $row['code'] ?>" class="btn btn-tvl btn-box">
        <?= $row['name'] ?> - <?= $row['grade_level'] ?>
        <br>
        <?= $row['code'] ?>
        </a>
        <?php } ?>
    </div>
    </div>
  </div>

</div>
</body>
</html>
