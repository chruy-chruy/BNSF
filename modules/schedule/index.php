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
  <title>Schedule Module</title>
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
$page = 'Schedule';
include "../../db_conn.php";
?>

<!-- Sidebar -->
<?php include "../../navbar.php";?>

<!-- Main Content (Schedule Module) -->
<div class="content" id="content">
  <h1>Schedule Module</h1>
  <p>Manage the list of schedules here.</p>

  <!-- Schedule Module -->
  <div id="scheduleSection" class="d-flex justify-content-center align-items-center" style="height: 50vh;">
    <div class="text-center">
      <!-- Button Container -->
      <div class="d-flex justify-content-center gap-4">
        <a href="sections.php?track=TVL&sy=<?php echo $sy ?>" class="btn btn-tvl btn-box">TVL</a>
        <a href="sections.php?track=Academic&sy=<?php echo $sy ?>" class="btn btn-academic btn-box">Academic</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
