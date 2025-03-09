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
  <title>Add Student</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- style -->
   <link rel="stylesheet" href="../../assets/css/styles.css">
   <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">

   <style>
.dropbtn {
  background-color: #198754;
  color: white;
  padding: 10px;
  font-size: 1rem;
  border: none;
  cursor: pointer;
}


#myInput {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>
</head>
<body>

  <!-- Sidebar -->
  <?php 
$page = "Student/$grade";
  include "../../navbar.php"; 
  include "../../db_conn.php";
  $strand_query = mysqli_query($conn, "SELECT * FROM strand WHERE del_status != 'deleted'");
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
      <h1 class="text-center mb-4">Student Registration</h1>
      <?php if($grade == "12"){ ?>
<!-- Add Student Dropdown Button -->
<div class="dropdown mb-3">
  <div class="dropdown">
  <button onclick="myFunction()" class="dropbtn btn btn-success dropdown-toggle">Existing Grade 11</button>
  <?php
    // Query to fetch student data
    $query = "SELECT s.*, CONCAT(t.name) AS strand_name 
    FROM student s 
    LEFT JOIN strand t ON s.strand = t.id 
    WHERE s.del_status != 'deleted' AND s.grade_level = '11'
    ORDER BY s.id DESC;";
    $result = mysqli_query($conn, $query);
    ?>
  <div id="myDropdown" class="dropdown-content">
    <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
    <a href="add.php?grade=12">None</a>
    <?php 
        // Loop through each row from the query result and populate the table
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $gender = $row['gender'];
            $Email = $row['email'];
            $strand = $row['strand_name'];
        ?>
    <a href="add.php?grade=12&student=<?php echo $id; ?>"><?php echo $full_name; ?></a>
    <?php } ?>
  </div>
</div>

<script>
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  const input = document.getElementById("myInput");
  const filter = input.value.toUpperCase();
  const div = document.getElementById("myDropdown");
  const a = div.getElementsByTagName("a");
  for (let i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>
</div>

<?php }?>

<?php
if (isset($_GET['student'])){
  $id2 = $_GET['student'];
    // Query to fetch student data
    $query2 = "SELECT s.*, CONCAT(t.name) AS strand_name 
    FROM student s 
    LEFT JOIN strand t ON s.strand = t.id 
    WHERE s.del_status != 'deleted' AND s.grade_level = '11' AND s.id = '$id2'";
    $result2 = mysqli_query($conn, $query2);
    $row = mysqli_fetch_assoc($result2);
}
?>

      <form action="create.php?<?php if (isset($_GET['student'])){ echo "student=" . $_GET['student']; } ?>" method="POST">

        <div class="row mb-3">
          <h3 class="mb-3">Personal Information</h3>
          <div class="col-md-6">
            <label for="lrn" class="form-label required">LRN</label>
            <input type="text" class="form-control" name="lrn" id="lrn" pattern="\d{13}" title="LRN must be exactly 13 digits" maxlength="13" value="<?php if (isset($_GET['student'])){ echo $row['lrn']; } ?>" required>
            <script>document.getElementById('lrn').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 13); // Allows only numbers, max 13 digits
});</script>
          </div>
          <div class="col-md-6">
            <label for="last_name" class="form-label required">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php if (isset($_GET['student'])){ echo $row['last_name']; } ?>" required
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" value="<?php if (isset($_GET['student'])){ echo $row['middle_name']; } ?>" name="middle_name"
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
          </div>
          <div class="col-md-6">
            <label for="first_name" class="form-label required">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php if (isset($_GET['student'])){ echo $row['first_name']; } ?>" required
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
          </div>
        </div>
        <div class="row mb-3">
          <!-- Gender -->
          <div class="col-md-4">
            <label for="gender" class="form-label required">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
              <option value="<?php if (isset($_GET['student'])){ echo $row['gender']; } ?>"><?php if (isset($_GET['student'])){ echo $row['gender']; }else { echo "Select"; } ?></option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>

          <div class="col-md-4">
            <label for="birthday" class="form-label required">Birthday</label>
            <input type="date" class="form-control" id="birthday" name="birthday" value="<?php if (isset($_GET['student'])){ echo $row['birthday']; } ?>" required>
          </div>

          <div class="col-md-4">
            <label for="nationality" class="form-label required">Nationality</label>
            <input type="text" class="form-control" id="nationality" name="nationality" value="<?php if (isset($_GET['student'])){ echo $row['nationality']; } ?>" required>
          </div>
        </div>
       
        <div class="row mb-3">
          <!-- <div class="col-md-4">
            <label for="age" class="form-label required">Age</label>
            <input type="number" class="form-control" id="age" name="age" required>
          </div> -->

        <!-- Strand -->
          <!-- <div class="col-md-6">
            <label for="strand" class="form-label required">Strand</label>
            <select class="form-select" id="strand" name="strand" required>
              <option value="<?php if (isset($_GET['student'])){ echo $row['strand']; } ?>" hidden>
              <?php if (isset($_GET['student'])){
                $strandId = $row['strand'];
                $strand_query2 = mysqli_query($conn, "SELECT * FROM strand WHERE del_status != 'deleted' AND id = '$strandId'");
                while ($strand2 = mysqli_fetch_assoc($strand_query2)){
                  echo $strand2['name']; 
              }
            }
              else { echo "Select"; }?>
              </option>
              <?php while ($strand = mysqli_fetch_assoc($strand_query)): ?> 
                            <option value="<?php echo $strand['id']; ?>"> <?php echo $strand['name']; ?> </option>       
              <?php endwhile; ?>  
            </select>
          </div> -->
          
          <!-- Grade -->
          <div class="col-md-12">
            <label for="grade_level" class="form-label required">Grade Level</label>
            <input type="text" class="form-control" id="grade_level" name="grade_level" value="<?php echo $grade; ?>" readonly>
          </div>
                <!-- fetch the strand names -->
          <!-- <?php if (isset($_GET['student'])){
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
            ?> -->

          <!-- <div class="col-md-3">
            <label for="grade_level" class="form-label required">Grade 11 Strand</label>
            <input type="text" class="form-control" id="grade_level" name="" value="<?php if (isset($grade11)){ echo $grade11; }else{ echo "N/A";} ?>" readonly >
          </div>

          
          <div class="col-md-3">
            <label for="grade_level" class="form-label required">Grade 12 Strand</label>
            <input type="text" class="form-control" id="grade_level" name="" value="<?php if (isset($grade12)){ echo $grade12; }else{ echo "N/A";} ?>" readonly>
            <input type="text" class="form-control" id="grade_level" name="grade_12" value="<?php if (isset($grade12)){ echo $grade12; }else{ echo "N/A";} ?>" readonly hidden>
          </div> -->



        </div>
        <div class="mb-3">
          <label for="address" class="form-label required">Address</label>
          <input type="text" class="form-control" id="address" name="address" value="<?php if (isset($_GET['student'])){ echo $row['address']; } ?>" required>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="contact" class="form-label required">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?php if (isset($_GET['student'])){ echo $row['contact']; } ?>" required>
          </div>

          <script>document.getElementById('contact').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 11); // Allows only numbers, max 13 digits
});</script>

          <div class="col-md-6">
            <label for="email" class="form-label required">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php if (isset($_GET['student'])){ echo $row['email']; } ?>" required>
          </div>
        </div>

        <h3 class="mb-3">Parent Information</h3>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="mothers_name" class="form-label required">Mother's Name</label>
            <input type="text" class="form-control" id="mothers_name" name="mothers_name" value="<?php if (isset($_GET['student'])){ echo $row['mothers_name']; } ?>" required
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
          </div>
          <div class="col-md-6">
            <label for="mothers_occupation" class="form-label">Mother's Occupation</label>
            <input type="text" class="form-control" id="mothers_occupation" name="mothers_occupation" value="<?php if (isset($_GET['student'])){ echo $row['mothers_occupation']; } ?>">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="fathers_name" class="form-label required">Father's Name</label>
            <input type="text" class="form-control" id="fathers_name" name="fathers_name" value="<?php if (isset($_GET['student'])){ echo $row['fathers_name']; } ?>" required
           pattern="[A-Za-z\s]+" title="Only letters and spaces are allowed" 
           oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
          </div>
          <div class="col-md-6">
            <label for="fathers_occupation" class="form-label">Father's Occupation</label>
            <input type="text" class="form-control" id="fathers_occupation" name="fathers_occupation" value="<?php if (isset($_GET['student'])){ echo $row['fathers_occupation']; } ?>">
          </div>
        </div>

        <h3 class="mb-3">User Information</h3>
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="username" class="form-label required">Username</label>
            <input type="text" class="form-control" id="username" name="username" required value="<?php if (isset($_GET['student'])){ echo $row['username']; } ?>" readonly>
          </div>
          <div class="col-md-6">
            <label for="password" class="form-label required">Password</label>
            <input type="text" class="form-control" id="password" name="password" value="<?php if (isset($_GET['student'])){ echo $row['password']; } ?>" readonly>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="student.php?grade=<?php echo $grade ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Cancel
          </a>
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

    // Auto-generate password based on lrn
    document.getElementById('lrn').addEventListener('input', function() {
        const lrnValue = this.value;
        document.getElementById('password').value = lrnValue; // Set password as the lrn
    });

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
</body>
</html>

<script src="../../assets/js/DataTables/jquery.min.js"></script>
<script src="../../assets/js/DataTables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/DataTables/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>