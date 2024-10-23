<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Schedule View</title>
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <style>
    .schedule-table th, .schedule-table td {
      padding: 8px;
      text-align: center;
    }
    .schedule-header {
      text-align: left;
      margin-bottom: 20px;
    }
    .schedule-header h2 {
      margin: 5px 0;
    }
    .summary-text {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <?php 
  $page = 'Schedule';
  include "../../navbar_teacher.php"; 
  ?>

  <div class="content" id="content">
    <div class="d-flex justify-content-center align-items-center ">
      <div class="schedule-header text-center">
        <h2>BULA NATIONAL SCHOOL OF FISHERIES</h2>
        <h4>General Santos City</h4>
        <p>Certificate of Registration<br>School Year: 2024-2025 Term: First Semester</p>
        <p>Teacher Name: John Doe<br>Subjects: Mathematics, Science</p>
      </div>
    </div>

    <table class="table table-bordered schedule-table">
      <thead class="thead-light">
        <tr>
          <th>Course No.</th>
          <th>Description</th>
          <th>Days</th>
          <th>Section</th>
          <th>Time</th>
        </tr>
      </thead>
      <tbody>
        <!-- Sample Data Rows -->
        <tr>
          <td >MAT101</td>
          <td >Mathematics</td>
          <td >MTH</td>
          <td >STEM1</td>
          <td>7:30 AM - 12:00 PM</td>
        </tr>

        <tr>
          <td>ENG102</td>
          <td>English</td>
          <td>TFR</td>
          <td >STEM1</td>
          <td>10:00 AM - 11:30 AM</td>
        </tr>

        <tr>
          <td>PE201</td>
          <td>Physical Education</td>
          <td>MTH</td>
          <td >HUMMS1</td>
          <td>1:00 PM - 2:30 PM</td>
        </tr>

        <tr>
          <td >SCI301</td>
          <td >Biology</td>
          <td >TFR</td>
          <td >HUMMS2</td>
          <td>1:00 PM - 5:30 PM</td>
        </tr>
      </tbody>
    </table>
  </div>

  <script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
