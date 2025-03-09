<?php
// Check if a message or error exists in the URL parameters
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $alertType = 'success'; // Set default alert type to 'success'
} elseif (isset($_GET['error'])) {
    $message = $_GET['error'];
    $alertType = 'danger'; // Set alert type to 'danger' for errors
}
$grade = $_GET['grade'];
?>
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
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">

</head>
<body>
<?php 
$page = "Student/$grade"; // For active page indicator in sidebar
include "../../db_conn.php"; // Include database connection

// Get the student ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the student data based on ID
    $query = "SELECT s.*, CONCAT(t.name) AS strand_name 
    FROM student s 
    LEFT JOIN strand t ON s.strand = t.id 
    WHERE s.del_status != 'deleted' AND s.id = '$id'
    ORDER BY s.id DESC;";

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

$strand_query = mysqli_query($conn, "SELECT * FROM strand WHERE del_status != 'deleted'");

?>

<!-- Sidebar -->
<?php include "../../navbar.php"; ?>

<!-- Main Content -->
<div class="content" id="content">
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


<div class="container my-5">
  <h1 class="text-center mb-4">View Student</h1>
<!-- Back Button -->
  <a href="student.php?grade=<?php echo $grade ?>" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Back
  </a>
  <form action="update.php?id=<?php echo $student['id']; ?>" method="POST">

    <!-- Personal Information -->
    <div class="row mb-3">
      <h3 class="mb-3">Personal Information</h3>
      <div class="col-md-6">
        <label for="lrn" class="form-label required">LRN</label>
        <input type="text" class="form-control" id="lrn" name="lrn" required 
        value="<?php echo $student['lrn']; ?>">
      </div>

      <script>document.getElementById('lrn').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 13); // Allows only numbers, max 13 digits
});</script>
      <div class="col-md-6">
        <label for="last_name" class="form-label required">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
        value="<?php echo $student['last_name']; ?>">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="middle_name" class="form-label">Middle Name</label>
        <input type="text" class="form-control" id="middle_name" name="middle_name" 
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
        value="<?php echo $student['middle_name']; ?>">
      </div>
      <div class="col-md-6">
        <label for="first_name" class="form-label required">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required 
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
        value="<?php echo $student['first_name']; ?>">
      </div>
    </div>

    <!-- Strand and Gender -->
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="gender" class="form-label required">Gender</label>
        <select class="form-select" id="gender" name="gender" required>
          <option hidden value="<?php echo $student['gender']; ?>"><?php echo $student['gender']; ?></option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="nationality" class="form-label required">Nationality</label>
        <input type="text" class="form-control" id="nationality" name="nationality" required
        value="<?php echo $student['nationality']; ?>">
      </div>
    </div>

    <!-- Age, Nationality, and Birthday -->
    <div class="row mb-3">
    <div class="col-md-6">
        <label for="age" class="form-label required">Age</label>
        <input readonly type="number" class="form-control" id="age" name="age" required
        value="<?php echo $student['age']; ?>">
      </div>
      
      <div class="col-md-6">
        <label for="birthday" class="form-label required">Birthday</label>
        <input type="date" class="form-control" id="birthday" name="birthday" required
        value="<?php echo $student['birthday']; ?>">
      </div>
    </div>

    <!-- Address -->
    <div class="mb-3">
      <label for="address" class="form-label required">Address</label>
      <input type="text" class="form-control" id="address" name="address" required
      value="<?php echo $student['address']; ?>">
    </div>

    <!-- Contact and Email -->
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="contact" class="form-label required">Contact</label>
        <input type="text" class="form-control" id="contact" name="contact" required
        value="<?php echo $student['contact']; ?>">
      </div>
      <script>document.getElementById('contact').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 11); // Allows only numbers, max 13 digits
});</script>
      <div class="col-md-6">
        <label for="email" class="form-label required">Email</label>
        <input type="email" class="form-control" id="email" name="email" required
        value="<?php echo $student['email']; ?>">
      </div>
    </div>
    <h3 class="mb-3">Educational Information</h3>
    <div class="row mb-3">

      <!-- <div class="col-md-6">
        <label for="strand" class="form-label required">Strand</label>
        <select class="form-select" id="strand" name="strand" required>
          <option hidden value="<?php echo $student['strand']; ?>"><?php echo $student['strand_name']; ?></option>
          <?php while($strand = mysqli_fetch_assoc($strand_query)): ?>
                            <option value="<?php echo $strand['id']; ?>">               
                              <?php echo $strand['name']; ?>     
                            </option>
                        <?php endwhile; ?>
        </select>
      </div> -->

      <div class="col-md-6">
            <label for="grade_level" class="form-label required">Grade Level</label>
            <input type="text" class="form-control" id="grade_level" name="grade_level" value="<?php echo $student['grade_level']; ?>" readonly>
      </div>
                <!-- fetch the strand names -->
                <?php if (isset($_GET['id'])){
                $strand11 = $student['grade_11'];
                $strand12 = $student['grade_12'];
                $grade11;
                $grade12;
                $strand_query2 = mysqli_query($conn, "SELECT * FROM strand WHERE del_status != 'deleted' AND id = '$strand11'");
                while ($strand2 = mysqli_fetch_assoc($strand_query2)){
                  $grade11 = $strand2['name'];
                  $strand11_id = $strand2['id'];
              }$strand_query3 = mysqli_query($conn, "SELECT * FROM strand WHERE del_status != 'deleted' AND id = '$strand12'");
              while ($strand3 = mysqli_fetch_assoc($strand_query3)){
                $grade12 = $strand3['name'];
                $strand12_id = $strand3['id'];
            }
            }
            ?>
          <div class="col-md-3">
            <label for="grade_level" class="form-label required">Strand 11 Strand</label>
            <input type="text" class="form-control" id="grade_level" name="" value="<?php if (isset($grade11)){ echo $grade11; }else{ echo "N/A";} ?>" readonly>
            
          </div>
          <div class="col-md-3">
            <label for="grade_level" class="form-label required">Strand 12 Strand</label>
            <input type="text" class="form-control" id="grade_level" name="" value="<?php if (isset($grade12)){ echo $grade12; }else{ echo "N/A";} ?>" readonly>
          </div>


    </div>

    <!-- Parent Information -->
    <h3 class="mb-3">Parent Information</h3>
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="mothers_name" class="form-label required">Mother's Name</label>
        <input type="text" class="form-control" id="mothers_name" name="mothers_name" required
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
        value="<?php echo $student['mothers_name']; ?>">
      </div>
      <div class="col-md-6">
        <label for="mothers_occupation" class="form-label">Mother's Occupation</label>
        <input type="text" class="form-control" id="mothers_occupation" name="mothers_occupation"
        value="<?php echo $student['mothers_occupation']; ?>">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="fathers_name" class="form-label required">Father's Name</label>
        <input type="text" class="form-control" id="fathers_name" name="fathers_name" required
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
        value="<?php echo $student['fathers_name']; ?>">
      </div>
      <div class="col-md-6">
        <label for="fathers_occupation" class="form-label">Father's Occupation</label>
        <input type="text" class="form-control" id="fathers_occupation" name="fathers_occupation"
        value="<?php echo $student['fathers_occupation']; ?>">
      </div>
    </div>

    <h3 class="mb-3">User Information</h3>
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="username" class="form-label required">Username</label>
            <input type="text" class="form-control" id="username" name="username" required readonly
            value="<?php echo $student['username']; ?>">
          </div>
          <div class="col-md-6">
            <label for="password" class="form-label required">Password</label>
            <input type="text" class="form-control" id="password" name="password" readonly
            value="<?php echo $student['password']; ?>">
          </div>
        </div>

    <!-- Submit and Delete Buttons -->
    <div class="text-center">
      <button type="submit" class="btn btn-primary">Submit</button>
      <!-- Delete Button -->
      <button type="button" class="btn btn-danger" id="deleteButton">
        <i class="bi bi-trash"></i> Delete
      </button>
    </div>
  </form>
</div>

<script>
// Auto-generate username based on email
document.getElementById('email').addEventListener('input', function() {
    const emailValue = this.value;
    document.getElementById('username').value = emailValue; // Set username as the email
});

// Auto-generate password based on lrn
document.getElementById('lrn').addEventListener('input', function() {
    const lrnValue = this.value;
    document.getElementById('password').value = lrnValue; // Set password as the lrn
});


// Confirm before deleting
document.getElementById('deleteButton').addEventListener('click', function() {
    const confirmed = confirm('Are you sure you want to delete this student?');
    if (confirmed) {
        window.location.href = 'delete.php?id=<?php echo $student['id']; ?>&grade=<?php echo $student['grade_level']; ?>'; // Redirect to delete page
    }
});
</script>

<!-- Bootstrap 5 JS -->
<script src="../../assets/js/DataTables/bootstrap.bundle.min.js"></script>
</body>
</html>
