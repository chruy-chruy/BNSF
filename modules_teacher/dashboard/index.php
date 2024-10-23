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
  ?>

  <div class="content" id="content">
    <!-- Dashboard Header -->
    <h1>Teacher Dashboard</h1>
    <p>Welcome to your teacher dashboard. Here you can view your assigned subjects, advisory section, and list of students:</p>

    <!-- Cards Row -->
    <div class="row">
      <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
          <div class="card-body">
            <h5 class="card-title">Assigned Subjects</h5>
            <p class="card-text">View the subjects you are teaching:</p>
            <ul>
              <li>Mathematics (MATH101)</li>
              <li>Science (SCI101)</li>
              <li>English (ENG102)</li>
              <li>History (HIS103)</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
          <div class="card-body">
            <h5 class="card-title">Advisory Section</h5>
            <p class="card-text">Check your advisory group details:</p>
            <p>Advisory Group: Grade 10 A</p>
            <p>Members: John Doe, Jane Smith</p>
            <p>Upcoming Events: Parent-Teacher Meeting on Nov 5</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
          <div class="card-body">
            <h5 class="card-title">Students Under Your Guidance</h5>
            <p class="card-text">View the students assigned to you:</p>
            <ul>
              <li>John Doe (ID: 12345)</li>
              <li>Jane Smith (ID: 67890)</li>
              <li>Emily Johnson (ID: 11223)</li>
              <li>Michael Brown (ID: 44556)</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Detailed Student List -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Detailed Student List</h5>
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Student Name</th>
                  <th>Student ID</th>
                  <th>Contact Information</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>John Doe</td>
                  <td>12345</td>
                  <td>johndoe@example.com</td>
                </tr>
                <tr>
                  <td>Jane Smith</td>
                  <td>67890</td>
                  <td>janesmith@example.com</td>
                </tr>
                <tr>
                  <td>Emily Johnson</td>
                  <td>11223</td>
                  <td>emilyj@example.com</td>
                </tr>
                <tr>
                  <td>Michael Brown</td>
                  <td>44556</td>
                  <td>michaelb@example.com</td>
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
