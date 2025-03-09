
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Module</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- style -->
   <link rel="stylesheet" href="../../assets/css/styles.css">
   <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">
</head>
<body>
<?php 
$page = 'Dashboard';

include "../../db_conn.php";
include "../../navbar.php";

//student
$query = mysqli_query($conn, "SELECT COUNT(id) AS total FROM `student` Where del_status != 'deleted'");
$row = mysqli_fetch_array($query);
$total_student = $row['total'];

//teacher
$query = mysqli_query($conn, "SELECT COUNT(id) AS total FROM `teacher` Where del_status != 'deleted'");
$row = mysqli_fetch_array($query);
$total_teacher = $row['total'];

//subject
$query = mysqli_query($conn, "SELECT COUNT(id) AS total FROM `subject` Where del_status != 'deleted'");
$row = mysqli_fetch_array($query);
$total_subject = $row['total'];

//strand
$query = mysqli_query($conn, "SELECT COUNT(id) AS total FROM `strand` Where del_status != 'deleted'");
$row = mysqli_fetch_array($query);
$total_strand = $row['total'];
 ?>

  <!-- Main Content -->
   <!-- Main Content (Dashboard) -->
   <div class="content" id="content">

    <!-- Dashboard Header -->
    <h1>Dashboard</h1>
    <p>Welcome to the admin dashboard. Here are the latest stats:</p>

    <!-- Cards Row -->
    <div class="row">
      <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
          <div class="card-body">
            <h5 class="card-title">Students</h5>
            <p class="card-text"><?php echo $total_student; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
          <div class="card-body">
            <h5 class="card-title">Teachers</h5>
            <p class="card-text"><?php echo $total_teacher; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
          <div class="card-body">
            <h5 class="card-title">Subjects</h5>
            <p class="card-text"><?php echo $total_subject; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
          <div class="card-body">
            <h5 class="card-title">Strand</h5>
            <p class="card-text"><?php echo $total_strand; ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart Placeholder -->
    <!-- <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Monthly Overview</h5>
            <p class="card-text">[Insert chart here]</p>
          </div>
        </div>
      </div>
    </div> -->

    <!-- Table -->
    <!-- <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Recent Activities</h5>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Activity</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>John Doe</td>
                  <td>Submitted Assignment</td>
                  <td>Oct 1, 2024</td>
                  <td><span class="badge bg-success">Completed</span></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Jane Smith</td>
                  <td>Missed Deadline</td>
                  <td>Oct 3, 2024</td>
                  <td><span class="badge bg-danger">Pending</span></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Bob Johnson</td>
                  <td>Attended Workshop</td>
                  <td>Oct 5, 2024</td>
                  <td><span class="badge bg-info">Ongoing</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> -->

  </div>


</body>
</html>
