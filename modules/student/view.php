<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Student</title>

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<?php 
$page = 'Student'; // For active page indicator in sidebar
include "../../db_conn.php"; // Include database connection

// Get the student ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the student data based on ID
    $query = "SELECT * FROM student WHERE id = '$id' AND del_status != 'deleted'";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);

    if (!$student) {
        // Redirect to index if the student is not found
        header("Location: index.php?error=Student not found.");
        exit();
    }
} else {
    header("Location: index.php?error=No student ID specified.");
    exit();
}
?>

<!-- Sidebar -->
<?php include "../../navbar.php"; ?>

<!-- Main Content -->
<div class="content" id="content">

<div id="studentSection">
  <h1>View Student</h1>

  <!-- Back Button -->
  <div class="d-flex justify-content-end mb-3">
    <a href="index.php" class="btn btn-secondary">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>

  <form action="update.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $student['id']; ?>">

    <!-- First Name -->
    <div class="mb-3">
      <label for="first_name" class="form-label">First Name</label>
      <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $student['first_name']; ?>" required>
    </div>

    <!-- Middle Name -->
    <div class="mb-3">
      <label for="middle_name" class="form-label">Middle Name</label>
      <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo $student['middle_name']; ?>">
    </div>

    <!-- Last Name -->
    <div class="mb-3">
      <label for="last_name" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $student['last_name']; ?>" required>
    </div>

    <!-- Sex -->
    <div class="mb-3">
      <label for="sex" class="form-label">Sex</label>
      <select class="form-select" id="sex" name="sex" required>
        <option value="">Select</option>
        <option value="Male" <?php echo ($student['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
        <option value="Female" <?php echo ($student['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
      </select>
    </div>

    <!-- Contact Number -->
    <div class="mb-3">
      <label for="contact_number" class="form-label">Contact Number</label>
      <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo $student['contact_number']; ?>" required>
    </div>

    <!-- Email -->
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?php echo $student['email']; ?>" required>
    </div>

    <!-- Username -->
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" id="username" name="username" value="<?php echo $student['username']; ?>" readonly required>
    </div>

    <!-- Password (Editable) -->
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="text" class="form-control" id="password" name="password" value="<?php echo $student['password']; ?>" required>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-primary">Save Changes</button>
      <a href="delete.php?id=<?php echo $student['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
    </div>
  </form>
</div>

</div>

<!-- Bootstrap 5 JS -->
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
