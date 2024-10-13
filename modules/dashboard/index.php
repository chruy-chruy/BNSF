<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap 5 Sidebar</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- style -->
   <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

  <!-- Sidebar -->
  <?php include "../../navbar.php"; ?>

  <!-- Main Content -->
   <!-- Main Content (Dashboard) -->

</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap 5 Sidebar</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- style -->
   <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<?php 
$page = 'Dashboard';

include "../../db_conn.php";
 ?>
  <!-- Sidebar -->
  <?php include "../../navbar.php"; ?>

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
            <p class="card-text">1,230</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
          <div class="card-body">
            <h5 class="card-title">Teachers</h5>
            <p class="card-text">230</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
          <div class="card-body">
            <h5 class="card-title">Classes</h5>
            <p class="card-text">45</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
          <div class="card-body">
            <h5 class="card-title">Pending Issues</h5>
            <p class="card-text">5</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart Placeholder -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Monthly Overview</h5>
            <p class="card-text">[Insert chart here]</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="row">
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
    </div>

  </div>


</body>
</html>
