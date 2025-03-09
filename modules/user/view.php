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
  <title>View User</title>

  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">

</head>
<body>
<?php 
$page = 'User'; // For active page indicator in sidebar
include "../../db_conn.php"; // Include database connection


    $ids = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM user WHERE id = '$ids'");
    // $row = mysqli_fetch_array($query);
    while ($row = mysqli_fetch_array($query)) {

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
      <h1 class="text-center mb-4">View User</h1>
      <a href="index.php" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Back
  </a>
      <form action="update.php?id=<?php echo $row['id'];?>" method="POST">

      <div class="row mb-3">
          <h3 class="mb-3">User Information</h3>
          <div class="col-md-6 mb-3" >
            <label for="name" class="form-label required">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required
            value = "<?php echo $row['name'];?>">
          </div>
          <div class="col-md-6 ">
            <label for="username" class="form-label required">User Name</label>
            <input type="text" class="form-control" id="username" name="username" required
            value = "<?php echo $row['username']; ?>">
          </div>
        

          <div class="col-md-6">
            <label for="password" class="form-label required">User Password</label>
            <input type="text" class="form-control" id="password" name="password" required
            value = "<?php echo $row['password']; ?>">
          </div>
  

          <div class="col-md-6">
            <label for="role" class="form-label required">User Role</label>
            <select name="role" class="form-control" required>
                        <option value="<?php echo $row['role']; ?>" hidden><?php echo $row['role']; ?></option>
                        <option value="Admin" >Admin</option>
                        <option value="Super Admin" >Super Admin</option>
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
    const confirmed = confirm('Are you sure you want to delete this Strand?');
    if (confirmed) {
        window.location.href = 'delete.php?id=<?php echo $row['id']; ?>'; // Redirect to delete page
    }
});
  </script>
  <?php }?>
<!-- Bootstrap 5 JS -->
<script src="../../assets/js/DataTables/bootstrap.bundle.min.js"></script>
</body>
</html>
