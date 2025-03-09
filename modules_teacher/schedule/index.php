<?php 
include "../../db_conn.php"; // Adjust this to your actual DB connection file

$page = 'Schedule';
include "../../navbar_teacher.php"; 

// Check if teacher is logged in
if (!isset($_SESSION['id'])) {
    die("Unauthorized access.");
}

$teacher_id = $_SESSION['id'];

// Fetch schedules, join with subject table, and get section (strand) name
$sql = "SELECT s.id, strand.name AS section_name, s.quarter, s.grade_level, s.time_from, s.time_to, 
            subj_monday.code AS monday, subj_tuesday.code AS tuesday, subj_wednesday.code AS wednesday, 
            subj_thursday.code AS thursday, subj_friday.code AS friday, 
            s.school_year, s.semester
        FROM schedules s
        LEFT JOIN strand ON s.section = strand.id
        LEFT JOIN subject subj_monday ON s.monday = subj_monday.id AND subj_monday.teacher_id = ?
        LEFT JOIN subject subj_tuesday ON s.tuesday = subj_tuesday.id AND subj_tuesday.teacher_id = ?
        LEFT JOIN subject subj_wednesday ON s.wednesday = subj_wednesday.id AND subj_wednesday.teacher_id = ?
        LEFT JOIN subject subj_thursday ON s.thursday = subj_thursday.id AND subj_thursday.teacher_id = ?
        LEFT JOIN subject subj_friday ON s.friday = subj_friday.id AND subj_friday.teacher_id = ?
        WHERE (subj_monday.id IS NOT NULL OR subj_tuesday.id IS NOT NULL OR 
               subj_wednesday.id IS NOT NULL OR subj_thursday.id IS NOT NULL OR subj_friday.id IS NOT NULL)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $teacher_id, $teacher_id, $teacher_id, $teacher_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>

  <div class="content" id="content">
    <h1>My Schedule</h1>
    <p>Welcome to your teacher schedule. Here you can view your assigned subjects and sections!</p>

    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Section</th>
          <th>Grade Level</th>
          <th>Time</th>
          <th>Monday</th>
          <th>Tuesday</th>
          <th>Wednesday</th>
          <th>Thursday</th>
          <th>Friday</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()) : ?>
          <tr>
            <td><?= htmlspecialchars($row['section_name']) ?></td>
            <td><?= htmlspecialchars($row['grade_level']) ?></td>
            <td><?= date("h:i A", strtotime($row['time_from'])) . " - " . date("h:i A", strtotime($row['time_to'])) ?></td>
            <td><?= !empty($row['monday']) ? htmlspecialchars($row['monday']) : '-' ?></td>
            <td><?= !empty($row['tuesday']) ? htmlspecialchars($row['tuesday']) : '-' ?></td>
            <td><?= !empty($row['wednesday']) ? htmlspecialchars($row['wednesday']) : '-' ?></td>
            <td><?= !empty($row['thursday']) ? htmlspecialchars($row['thursday']) : '-' ?></td>
            <td><?= !empty($row['friday']) ? htmlspecialchars($row['friday']) : '-' ?></td>

          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script src="../../assets/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
