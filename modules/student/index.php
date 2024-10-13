<!DOCTYPE html>
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
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php 
$page = 'Student';
include "../../db_conn.php"; 
?>
  
<!-- Sidebar -->
<?php include "../../navbar.php"; ?>

<!-- Main Content (Student Module with DataTable) -->
<div class="content" id="content">

  <!-- Student Module -->
  <div id="studentSection">
    <h1>Student Module</h1>
    <p>Manage the list of students here.</p>

    <!-- Add Student Button -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>

    <!-- Student Table with DataTable -->
    <?php
    // Query to fetch student data
    $query = "SELECT id, first_name, middle_name, last_name, sex, grade_level, strand, section FROM student WHERE del_status != 'deleted'";
    $result = mysqli_query($conn, $query);
    ?>

    <table id="studentTable" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Full Name</th>
          <th>Sex</th>
          <th>Grade Level</th>
          <th>Strand</th>
          <th>Section</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Loop through each row from the query result and populate the table
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $sex = $row['sex'];
            $grade_level = $row['grade_level'];
            $strand = $row['strand'];
            $section = $row['section'];
        ?>
        <tr>
          <td><?php echo $id; ?></td>
          <td><?php echo $full_name; ?></td>
          <td><?php echo $sex; ?></td>
          <td><?php echo $grade_level; ?></td>
          <td><?php echo $strand; ?></td>
          <td><?php echo $section; ?></td>
          <td class="text-end">
            <a href="view.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">View</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

    <?php 
    // Close the database connection
    mysqli_close($conn);
    ?>
  </div>

 <!-- Add Student Modal -->
 <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="create.php" method="POST">
              <!-- First Name -->
              <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
              </div>
              
              <!-- Middle Name -->
              <div class="mb-3">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name">
              </div>
              
              <!-- Last Name -->
              <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
              </div>

              <!-- Sex -->
              <div class="mb-3">
                <label for="sex" class="form-label">Sex</label>
                <select class="form-select" id="sex" name="sex" required>
                  <option value="">Select</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              
              <!-- Address -->
              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
              </div>

              <!-- Contact Number -->
              <div class="mb-3">
                <label for="contact_number" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="contact_number" name="contact_number" required>
              </div>
              
              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required oninput="generateUsername()">
              </div>
              
              <!-- Grade Level -->
              <div class="mb-3">
                <label for="grade_level" class="form-label">Grade Level</label>
                <select class="form-select" id="grade_level" name="grade_level" required>
                  <option value="">Select</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
              </div>

              <!-- Strand -->
              <div class="mb-3">
                <label for="strand" class="form-label">Strand</label>
                <select class="form-select" id="strand" name="strand" required>
                  <option value="">Select</option>
                  <option value="STEM">STEM</option>
                  <option value="HUMMS">HUMMS</option>
                  <option value="ABM">ABM</option>
                  <option value="GAS">GAS</option>
                </select>
              </div>

              <!-- Section -->
              <div class="mb-3">
                <label for="section" class="form-label">Section</label>
                <input type="text" class="form-control" id="section" name="section" required>
              </div>

              <!-- Username (Auto-generated based on email) -->
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" readonly required>
              </div>
              
              <!-- Password (Auto-generated based on full name) -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" id="password" name="password" readonly required>
              </div>

              <!-- Submit Button -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Student</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Auto-generate username based on email
    document.getElementById('email').addEventListener('input', function() {
      const emailValue = this.value;
      document.getElementById('username').value = emailValue; // Set username as the email
    });

    // Auto-generate password based on full name (first + last name) and add 3 random digits
    document.getElementById('first_name').addEventListener('input', generatePassword);
    document.getElementById('last_name').addEventListener('input', generatePassword);

    function generatePassword() {
      const firstName = document.getElementById('first_name').value;
      const lastName = document.getElementById('last_name').value;
      if (firstName && lastName) {
        const randomNumbers = Math.floor(100 + Math.random() * 900); // Generate 3 random digits
        const password = firstName.toLowerCase() + lastName.toLowerCase() + randomNumbers;
        document.getElementById('password').value = password; // Set password as first + last name + 3 random digits
      }
    }

    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordField = document.getElementById('password');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        this.textContent = 'Hide';
      } else {
        passwordField.type = 'password';
        this.textContent = 'Show';
      }
    });
  </script>
<script src="../../assets/js/DataTables/jquery.min.js"></script>
<script src="../../assets/js/DataTables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/DataTables/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize DataTable
    $('#studentTable').DataTable({
      responsive: true // Optional: Make the table responsive
    });
  });
</script>

<!-- Additional CSS for DataTables -->
<style>
  .dataTables_filter {
    float: right; /* Moves the search bar to the right */
  }
</style>

</body>
</html>