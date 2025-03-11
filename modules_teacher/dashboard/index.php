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
  <?php 
  $page = 'Dashboard';
  include "../../navbar_teacher.php"; 

  // Fetch teacher details
  $teacher_id = $_SESSION['id'];

  // Get advisory section from strand table
  $sql_advisory = "SELECT name FROM strand WHERE id = (SELECT section FROM schedules WHERE adviser = ? LIMIT 1)";
  $stmt_advisory = $conn->prepare($sql_advisory);
  $stmt_advisory->bind_param("i", $teacher_id);
  $stmt_advisory->execute();
  $result_advisory = $stmt_advisory->get_result();
  $advisory_section = $result_advisory->fetch_assoc()['name'] ?? 'None';
  $stmt_advisory->close();

  // Get assigned subjects with section names
  $sql_subjects = "SELECT * FROM subject WHERE teacher_id = ?";
  $stmt_subjects = $conn->prepare($sql_subjects);
  $stmt_subjects->bind_param("i", $teacher_id);
  $stmt_subjects->execute();
  $result_subjects = $stmt_subjects->get_result();

  // Get count of assigned subjects
  $sql_subject_count = "SELECT COUNT(*) AS subject_count FROM subject WHERE teacher_id = ?";
  $stmt_subject_count = $conn->prepare($sql_subject_count);
  $stmt_subject_count->bind_param("i", $teacher_id);
  $stmt_subject_count->execute();
  $result_subject_count = $stmt_subject_count->get_result();
  $subject_count = $result_subject_count->fetch_assoc()['subject_count'] ?? 0;
  $stmt_subject_count->close();
  ?>

  <div class="content" id="content">
    <h1>Teacher Dashboard</h1>
    <p>Welcome to your teacher dashboard. Here you can view your assigned subjects and advisory section:</p>

    <div class="row">
      <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
          <div class="card-body">
            <h5 class="card-title">Advisory Section</h5>
            <p class="card-text"><?= htmlspecialchars($advisory_section) ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
          <div class="card-body">
            <h5 class="card-title">Subjects Assigned</h5>
            <p class="card-text"><?= $subject_count ?></p>
          </div>
        </div>
      </div>
    </div>

    <h3>Assigned Subjects</h3>
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Subject Code</th>
          <th>Subject Details</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result_subjects->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['code']) ?></td>
            <td><?= htmlspecialchars($row['details']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
