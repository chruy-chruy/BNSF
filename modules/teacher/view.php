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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Teacher</title>

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
<?php 
$page = 'Teacher'; // For active page indicator in sidebar
include "../../db_conn.php"; // Include database connection

// Get the teacher ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the teacher data based on ID
    $query = "SELECT * FROM teacher WHERE id = '$id' AND del_status != 'deleted'";
    $result = mysqli_query($conn, $query);
    $teacher = mysqli_fetch_assoc($result);

    if (!$teacher) {
        // Redirect to index if the teacher is not found
        header("Location: index.php?error=Teacher not found.");
        exit();
    }
} else {
    header("Location: index.php?error=No teacher ID specified.");
    exit();
}
?>

<!-- Sidebar -->
<?php include "../../navbar.php"; ?>

<!-- Main Content -->
<div class="content" id="content">
<div class="container mt-4">

<?php if (isset($message)): ?>
<!-- Bootstrap 5 Alert -->
<div id="autoDismissAlert" class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
    <?php echo $message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

</div>

<!-- Auto-dismiss alert after 3 seconds using simple JavaScript -->
<script>
// Select the alert element
var alert = document.getElementById('autoDismissAlert');

// Set timeout for 3 seconds (3000 ms)
if (alert) {
    setTimeout(function() {
        // Fade out the alert (optional smooth fade out)
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';

        // After fading out, remove the alert element from the DOM
        setTimeout(function() {
            alert.remove();
        }, 500); // Remove after fade-out completes (500 ms)
    }, 3000); // 3 seconds delay
}
</script>
    <div class="container my-5">
      <h1 class="text-center mb-4">View Teacher</h1>
      <a href="index.php" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Back
  </a>
      <form action="update.php?id=<?php echo $teacher['id']; ?>" method="POST">

        <div class="row mb-3">
          <h3 class="mb-3">Personal Information</h3>
          <div class="col-md-6">
            <label for="id_number" class="form-label required">ID Number</label>
            <input type="text" class="form-control" id="id_number" name="id_number" required 
            value="<?php echo $teacher['id_number']; ?>">
          </div>
          <div class="col-md-6">
            <label for="last_name" class="form-label required">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required
            value="<?php echo $teacher['last_name']; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name"
            value="<?php echo $teacher['middle_name']; ?>">
          </div>
          <div class="col-md-6">
            <label for="first_name" class="form-label required">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required
            value="<?php echo $teacher['first_name']; ?>">
          </div>
        </div>

        <!-- Gender -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="gender" class="form-label required">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
              <option hidden value="<?php echo $teacher['gender']; ?>"><?php echo $teacher['gender']; ?></option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <!-- Nationality -->
          <div class="col-md-6">
            <label for="nationality" class="form-label required">Nationality</label>
            <input type="text" class="form-control" id="nationality" name="nationality" required
            value="<?php echo $teacher['nationality']; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="age" class="form-label required">Age</label>
            <input type="number" class="form-control" id="age" name="age" required
            value="<?php echo $teacher['age']; ?>">
          </div>
          <div class="col-md-6">
            <label for="birthday" class="form-label required">Birthday</label>
            <input type="date" class="form-control" id="birthday" name="birthday" required
            value="<?php echo $teacher['birthday']; ?>">
          </div>
        </div>

        <div class="mb-3">
          <label for="address" class="form-label required">Address</label>
          <input type="text" class="form-control" id="address" name="address" required
          value="<?php echo $teacher['address']; ?>">
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="contact" class="form-label required">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" required
            value="<?php echo $teacher['contact']; ?>">
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label required">Email</label>
            <input type="email" class="form-control" id="email" name="email" required
            value="<?php echo $teacher['email']; ?>">
          </div>
        </div>

        <h3 class="mb-3">User Information</h3>
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="username" class="form-label required">Username</label>
            <input type="text" class="form-control" id="username" name="username" required readonly
            value="<?php echo $teacher['username']; ?>">
          </div>
          <div class="col-md-6">
            <label for="password" class="form-label required">Password</label>
            <input type="text" class="form-control" id="password" name="password" readonly
            value="<?php echo $teacher['password']; ?>">
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" id="deleteButton">
        <i class="bi bi-trash"></i> Delete
      </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // Auto-generate username based on email
    document.getElementById('email').addEventListener('input', function() {
        const emailValue = this.value;
        document.getElementById('username').value = emailValue; // Set username as the email
    });

    // Auto-generate password based on ID number
    document.getElementById('id_number').addEventListener('input', function() {
        const idNumberValue = this.value;
        document.getElementById('password').value = idNumberValue; // Set password as the ID number
    });

    // Confirm before deleting
document.getElementById('deleteButton').addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to delete this teacher?');
    if (confirmed) {
        window.location.href = 'delete.php?id=<?php echo $teacher['id']; ?>'; // Redirect to delete page
    }
});
  </script>
<!-- Bootstrap 5 JS -->
<script src="../../assets/js/DataTables/bootstrap.bundle.min.js"></script>
</body>
</html>
