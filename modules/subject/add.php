<?php
// Check if a message or error exists in the URL parameters
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $alertType = 'success'; // Set default alert type to 'success'
} elseif (isset($_GET['error'])) {
    $message = $_GET['error'];
    $alertType = 'danger'; // Set alert type to 'danger' for errors
}

include "../../db_conn.php";
$grade = $_GET['grade'];

// Fetch teachers from the database
$teachers_query = mysqli_query($conn, "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM teacher Where del_status != 'deleted'"); // Adjust table name and columns as necessary

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Subject</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">

</head>
<body>

  <!-- Sidebar -->
  <?php 
  $page = 'Subject'; 
  include "../../navbar.php"; 
  ?>

  <!-- Main Content -->
  <div class="content" id="content">
    <div class="container my-5">
    <div class="container mt-4">

<?php if (isset($message)): ?>
<!-- Bootstrap 5 Alert -->
<div id="autoDismissAlert" class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x custom-alert" role="alert">
    <?php echo $message; ?>
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
      <h1 class="text-center mb-4">Add Subject</h1>

      <form action="create.php" method="POST">

        <div class="row mb-3">
          <h3 class="mb-3">Subject Information</h3>
          <!-- <div class="col-md-6">
            <label for="subject_name" class="form-label required">Subject Name</label>
            <input type="text" class="form-control" id="subject_name" name="subject_name" required>
          </div> -->
          <div class="col-md-6">
            <label for="subject_code" class="form-label required">Subject Code</label>
            <input type="text" class="form-control" id="subject_code" name="subject_code" required>
          </div>
          <div class="col-md-6">
            <label for="grade_level" class="form-label required">Grade Level</label>
            <input type="text" class="form-control" id="grade_level" name="grade_level" value="<?php echo $grade;?>" readonly required>
        </div>
        </div>

        <div class="row mb-3">

          <div class="col-md-6">
            <label for="teacher_id" class="form-label required">Assigned Teacher</label>
            <select name="teacher_id" class="form-control" required>
                        <option value="" hidden>Select a Teacher</option>
                        <?php while($teacher = mysqli_fetch_assoc($teachers_query)): ?>
                            <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['full_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
          </div>

          <div class="col-md-6">
            <label for="details" class="form-label">Subject Description</label>
            <textarea type="text" class="form-control" id="details" name="details"></textarea>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="./" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Cancel
          </a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
