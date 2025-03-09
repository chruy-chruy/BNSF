<?php
include "../../db_conn.php"; // Adjust based on your setup

$page = 'Students';
include "../../navbar_teacher.php";

// Check if teacher is logged in and section_id is provided
if (!isset($_SESSION['id']) || !isset($_GET['section_id'])) {
    die("Unauthorized access.");
}

$teacher_id = $_SESSION['id'];
$section_id = intval($_GET['section_id']);
$selected_grade_level = isset($_GET['grade_level']) ? intval($_GET['grade_level']) : null;

// Get section name
$sql_section_name = "SELECT name FROM strand WHERE id = ?";
$stmt_section_name = $conn->prepare($sql_section_name);
$stmt_section_name->bind_param("i", $section_id);
$stmt_section_name->execute();
$result_section_name = $stmt_section_name->get_result();
$section = $result_section_name->fetch_assoc()['name'] ?? "Unknown Section";
$stmt_section_name->close();

// Get students based on selected grade level and section
if ($selected_grade_level) {
    $sql_students = "SELECT id, lrn, first_name, middle_name, last_name, gender, age 
                     FROM student
                     WHERE grade_level = ? 
                     AND ((grade_11 = ? AND (grade_12 IS NULL OR grade_12 = 0)) OR grade_12 = ?)";
    $stmt_students = $conn->prepare($sql_students);
    $stmt_students->bind_param("iii", $selected_grade_level, $section_id, $section_id);
    $stmt_students->execute();
    $result_students = $stmt_students->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard - <?= htmlspecialchars($section) ?></title>
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>

  <div class="content">
    <h1>Students in <?= htmlspecialchars($section) ?></h1>
    <a href="index.php" class="btn btn-secondary mb-3">Back to Sections</a>

    <?php if (!$selected_grade_level): ?>
      <h3>Select Grade Level:</h3>
      <?php foreach ($grade_levels as $grade): ?>
        <a href="student.php?section_id=<?= $section_id ?>&grade_level=<?= $grade ?>" class="btn btn-primary">Grade <?= $grade ?></a>
      <?php endforeach; ?>

    <?php else: ?>
      <h3>Grade <?= $selected_grade_level ?> Students</h3>
      
      <?php if ($result_students->num_rows > 0): ?>
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
                  <a href="grade.php?student_id=<?= $row['id'] ?>&section_id=<?= $section_id ?>&grade_level=<?= $selected_grade_level ?>" class="btn btn-primary">Manage Grades</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No students found in Grade <?= $selected_grade_level ?> for this section.</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>

  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/DataTables/jquery.min.js"></script>
  <script src="../../assets/js/DataTables/jquery.dataTables.min.js"></script>
  <script src="../../assets/js/DataTables/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#studentTable').DataTable({
        responsive: true
      });
    });
  </script>

  <style>
    .dataTables_filter {
      float: right;
    }
  </style>
</body>
</html>
