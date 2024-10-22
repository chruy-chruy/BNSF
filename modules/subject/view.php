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
  <title>View Sbuject</title>

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
<?php 
$page = 'Subject'; // For active page indicator in sidebar
include "../../db_conn.php"; // Include database connection

// Get the teacher ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($conn, "
    SELECT s.*, CONCAT(t.first_name, ' ', t.last_name) AS teacher_name 
    FROM subject s 
    LEFT JOIN teacher t ON s.teacher_id = t.id 
    WHERE s.del_status != 'deleted' 
    ORDER BY s.id DESC;
");
    $row = mysqli_fetch_array($query);
  
    $teachers_query = mysqli_query($conn, "
SELECT id, CONCAT(first_name, ' ', last_name) AS full_name 
FROM teacher WHERE del_status != 'deleted'
");
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
      <h1 class="text-center mb-4">View Subject</h1>
      <a href="index.php" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Back
  </a>
      <form action="update.php?id=<?php echo $row['id']; ?>" method="POST">

      <div class="row mb-3">
          <h3 class="mb-3">Subject Information</h3>
          <div class="col-md-6">
            <label for="subject_name" class="form-label required">Subject Name</label>
            <input type="text" class="form-control" id="subject_name" name="subject_name" required
            value = "<?php echo $row['name']; ?>">
          </div>
          <div class="col-md-6">
            <label for="subject_code" class="form-label required">Subject Code</label>
            <input type="text" class="form-control" id="subject_code" name="subject_code" required
            value = "<?php echo $row['code']; ?>">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="details" class="form-label">Details</label>
            <input type="text" class="form-control" id="details" name="details"
            value = "<?php echo $row['details']; ?>">
          </div>
          
          <div class="col-md-6">
            <label for="teacher_id" class="form-label required">Assigned Teacher</label>
            <select name="teacher_id" class="form-control" required>
                        <option value="<?php echo $row['teacher_id']; ?>" hidden><?php echo $row['teacher_name']; ?></option>
                        <?php while($teacher = mysqli_fetch_assoc($teachers_query)): ?>
                          <option value="<?php echo $teacher['full_name']; ?>" hidden><?php echo $teacher['full_name']; ?></option> 
                            <option value="<?php echo $teacher['id']; ?>" 
                                <?php echo (isset($row['teacher_id']) && $row['teacher_id'] == $teacher['id']) ? 'selected' : ''; ?>>               
                                <?php echo $teacher['full_name']; ?>     
                            </option>
                        <?php endwhile; ?>
                    </select>
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
    // Confirm before deleting
document.getElementById('deleteButton').addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to delete this subject?');
    if (confirmed) {
        window.location.href = 'delete.php?id=<?php echo $row['id']; ?>'; // Redirect to delete page
    }
});
  </script>
<!-- Bootstrap 5 JS -->
<script src="../../assets/js/DataTables/bootstrap.bundle.min.js"></script>
</body>
</html>
