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

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Module</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="../../assets/css/DataTables/jquery.dataTables.min.css">
  <!-- Custom Style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>

  <!-- Sidebar -->
  <?php include "../../navbar.php"; ?>
  <div class="content" id="content">
  <div class="container d-flex justify-content-center align-items-center" style="min-height: 500px;">
    <!-- Main Content -->
    <div class="text-center">
      <h1 class="mb-4">Choose Grade Level</h1>
      <div>
        <a href="/grade11" class="btn btn-primary btn-lg mx-5">Grade 11</a>
        <a href="/grade12" class="btn btn-secondary btn-lg mx-5">Grade 12</a>
      </div>
    </div>
  </div>
</div>


</body>
</html>
