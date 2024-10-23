<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
  <?php 
  $page = 'Dashboard';
  include "../../navbar_student.php"; 
  ?>

  <div class="content" id="content">
    <!-- Dashboard Header -->
    <h1>Student Dashboard</h1>
    <p>Welcome to your student dashboard. Here you can view your grades and class schedule:</p>

    <!-- Cards Row -->
    <div class="row">
      <div class="col-md-6">
        <div class="card text-white bg-info mb-3">
          <div class="card-body">
            <h5 class="card-title">Your Grades</h5>
            <p class="card-text">View your current grades for each subject below:</p>
            <ul>
              <li>Mathematics: 89</li>
              <li>Science: 92</li>
              <li>English: 85</li>
              <li>History: 88</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card text-white bg-success mb-3">
          <div class="card-body">
            <h5 class="card-title">Class Schedule</h5>
            <p class="card-text">Check your class schedule below:</p>
            <ul>
              <li>Monday: 9:00 AM - 10:30 AM (Mathematics)</li>
              <li>Tuesday: 10:45 AM - 12:15 PM (Science)</li>
              <li>Wednesday: 1:00 PM - 2:30 PM (English)</li>
              <li>Thursday: 2:45 PM - 4:15 PM (History)</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Grade Table Example -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Detailed Grades</h5>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Subject</th>
                  <th>Grade</th>
                  <th>Remarks</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Mathematics</td>
                  <td>89</td>
                  <td>Passed</td>
                </tr>
                <tr>
                  <td>Science</td>
                  <td>92</td>
                  <td>Passed</td>
                </tr>
                <tr>
                  <td>English</td>
                  <td>85</td>
                  <td>Passed</td>
                </tr>
                <tr>
                  <td>History</td>
                  <td>88</td>
                  <td>Passed</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
