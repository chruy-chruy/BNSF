<?php
// Check if a message or error exists in the URL parameters
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $alertType = 'success'; // Set default alert type to 'success'
} elseif (isset($_GET['error'])) {
    $message = $_GET['error'];
    $alertType = 'danger'; // Set alert type to 'danger' for errors
}

$track = $_GET['track'];
include "../../db_conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Strand on <?php echo $track; ?></title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>

  <!-- Sidebar -->
  <?php 
$page = "Strand/$track";
  include "../../navbar.php"; 
  $teachers_query = mysqli_query($conn, "
SELECT id, CONCAT(first_name, ' ', last_name) AS full_name 
FROM teacher 
WHERE id NOT IN (SELECT teacher_id FROM strand WHERE teacher_id IS NOT NULL AND del_status != 'deleted')
");
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
      <h1 class="text-center mb-4">Add Strand</h1>

      <form action="create.php" method="POST">

        <div class="row mb-3">
          <h3 class="mb-3">Strand Information</h3>
          
          <div class="col-md-6 mb-3">
            <label for="strand_name" class="form-label required">Strand Name</label>
            <input type="text" class="form-control" id="strand_name" name="strand_name" required>
          </div>
       
          <div class="col-md-6 mb-3">
            <label for="strand_code" class="form-label required">Strand Section</label>
            <input type="text" class="form-control" id="strand_code" name="strand_code" required>
          </div>

          <div class="col-md-6 mb-3">
            <label for="teacher_id" class="form-label required">Assigned Adviser</label>
            <select name="teacher_id" class="form-control" required>
                        <option value="" hidden>Select a Teacher</option>
                        <?php while ($teacher = mysqli_fetch_assoc($teachers_query)): ?> 
                            <option value="<?php echo $teacher['id']; ?>" <?php echo (isset($row['teacher_id']) && $row['teacher_id'] == $teacher['id']) ? 'selected' : ''; ?>>         
                                <?php echo $teacher['full_name']; ?>     
                            </option>       
                        <?php endwhile; ?>  
                    </select>
          </div>

          <div class="col-md-6 mb-3">
            <label for="track" class="form-label required">Track Name</label>
            <input type="text" class="form-control" id="track" name="track" value="<?php echo $track; ?>" readonly>
          </div>

          <div class="col-md-12 mb-3">
            <label for="details" class="form-label required">Strand Details</label>
            <textarea type="text" class="form-control" id="details" name="details" required></textarea>
          </div>
        </div>
        

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="./?track=<?php echo $track;?>" class="btn btn-secondary"></i> Cancel</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
