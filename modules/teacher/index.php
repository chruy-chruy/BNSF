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
  <title>Teacher Module</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- style -->
   <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">

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
<a href="add.php" class="btn btn-success mb-3">Add Teacher</a>
<div class="container mt-4">

<?php if (isset($message)): ?>
<!-- Bootstrap 5 Alert -->
<div id="autoDismissAlert" class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x custom-alert" role="alert">
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

  <!-- Teacher Table with DataTable -->
  <?php
include "../../db_conn.php"; // Include database connection

// Query to fetch teacher data
$query = "SELECT * FROM teacher WHERE del_status != 'deleted'";
$result = mysqli_query($conn, $query);
?>

<table id="teacherTable" class="table table-striped table-hover">
  <thead>
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Email</th>
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
      <td><?php echo $row['email']; ?></td>
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
<!-- DataTable JS and Bootstrap 5 JS -->
<script src="../../assets/js/DataTables/jquery.min.js"></script>
<script src="../../assets/js/DataTables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/DataTables/dataTables.bootstrap5.min.js"></script>
<script src="../../assets/js/DataTables/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/DataTables/table.js"></script>
<script>
  $(document).ready(function() {
    // Initialize DataTable
    $('#teacherTable').DataTable({
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
