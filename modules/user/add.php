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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add User</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>

  <!-- Sidebar -->
  <?php 
  $page = 'User'; 
  include "../../navbar.php";
  ?>

  <!-- Main Content -->
  <div class="content" id="content">
    <div class="container my-5">
    <div class="container mt-4">

<?php if (isset($message)): ?>
<!-- Bootstrap 5 Alert -->
<div id="autoDismissAlert" class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
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
      <h1 class="text-center mb-4">Add User</h1>

      <form action="create.php" method="POST">

        <div class="row mb-3">
          <h3 class="mb-3">User Information</h3>
          
          <div class="col-md-6">
            <label for="name" class="form-label required">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="col-md-6 mb-3">
            <label for="username" class="form-label required">User Name</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>

        <div class="col-md-6">
            <label for="password" class="form-label required">User Password</label>
            <input type="text" class="form-control" id="password" name="password" required>
        </div>
        
          
          <div class="col-md-6">
            <label for="role" class="form-label required">User Role</label>
            <select name="role" class="form-control" required>
                        <option value="" hidden>Select a User Role</option>
                        <option value="Registrar" >Registrar</option>
                        <option value="Administrator" >Administrator</option>
                    </select>
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
