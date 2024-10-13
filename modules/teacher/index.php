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
$page = 'Teacher';

include "../../db_conn.php";
 ?>
  <!-- Sidebar -->
  <?php include "../../navbar.php";?>

 <!-- Main Content (Teacher Module with DataTable) -->
<div class="content" id="content">

<!-- Teacher Module -->
<div id="teacherSection">
  <h1>Teacher Module</h1>
  <p>Manage the list of teachers here.</p>

  <!-- Add Teacher Button -->
  <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addTeacherModal">Add Teacher</button>

  <!-- Teacher Table with DataTable -->
  <?php
include "../../db_conn.php"; // Include database connection

// Query to fetch teacher data
$query = "SELECT id, first_name, middle_name, last_name FROM teacher WHERE del_status != 'deleted'";
$result = mysqli_query($conn, $query);
?>

<table id="teacherTable" class="table table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th class="text-end">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    // Loop through each row from the query result and populate the table
    while($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
    ?>
    <tr>
      <td><?php echo $id; ?></td>
      <td><?php echo $full_name; ?></td>
      <td class="text-end">
        <a href="view.php?id=<?php echo $id; ?>" class="btn btn-info btn-sm">view</a>
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

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTeacherModalLabel">Add New Teacher</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="container mt-5">
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
      
      <!-- Contact Number -->
      <div class="mb-3">
        <label for="contact_number" class="form-label">Contact Number</label>
        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
      </div>
      
      <!-- Email (Used to auto-generate username) -->
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      
      <!-- Username (Auto-generated based on email) -->
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" readonly required>
      </div>
      
      <!-- Password (Auto-generated based on full name) -->
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" required>
          <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
        </div>
      </div>
      <!-- Submit Button -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Teacher</button>
      </div>
    </form>
  </div>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Custom JS for Username, Password Generation, and Password Toggle -->
 <!-- Custom JS for Username, Password Generation, and Password Toggle -->
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
      </div>
    </div>
  </div>
</div>

</div>

<!-- DataTable JS and Bootstrap 5 JS -->
<script src="../../assets/js/DataTables/jquery.min.js"></script>
<script src="../../assets/js/DataTables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/DataTables/dataTables.bootstrap5.min.js"></script>
<script src="../../assets/js/DataTables/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/DataTables/table.js"></script>
<style>.dataTables_filter {
    float: right; /* Moves the search bar to the right */
  }</style>

</body>
</html>
