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

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Module</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- Custom Style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">

</head>
<style>
  @media print {
    body * {
      visibility: hidden;
    }
    #studentTable, #studentTable * {
      visibility: visible;
    }
    #studentTable {
      position: absolute;
      left: 0;
      top: 0;
    }

    /* Hide the 'Actions' column during print */
    #studentTable th.text-end,
    #studentTable td.text-end {
      display: none;
    }
  }
</style>

<body>

<?php 
$page = "Student";
include "../../db_conn.php"; 
?>
  
<!-- Sidebar -->
<?php include "../../navbar.php"; ?>

<!-- Main Content (Student Module with DataTable) -->
<div class="content" id="content">

  <!-- Student Module -->
  <div id="studentSection">
    <h1>Student Module Grade <?php echo $grade ?></h1>
    <p>Manage the list of students here.</p>

    <!-- Add Student Button -->
<a href="add.php?grade=<?php echo $grade;?>" class="btn btn-success mb-3">Add Student</a>
  <!-- Print Button -->
  <a href="javascript:printTable()" class="btn btn-primary mb-3">Print</a>
<script>
  function printTable() {
    var printContent = document.getElementById('studentTable').outerHTML;

    // Remove the Action column from the print view
    printContent = printContent.replace(/<th class="text-end">Actions<\/th>/, ''); // Remove header column
    printContent = printContent.replace(/<td class="text-end">.*?<\/td>/g, ''); // Remove data cells in Action column

    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Student List</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">');
    printWindow.document.write('<style>@media print {#studentTable th.text-end,#studentTable td.text-end {display: none;}}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h1>Student List</h1>');  // Set the title as 'Student List'
    printWindow.document.write('<table class="table table-striped table-hover">' + printContent + '</table>');
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
  }
</script>

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
<a href="index.php" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Back
  </a>
    <!-- Student Table with DataTable -->
    <?php
    // Query to fetch student data
    if($grade == '11'){
      $strand = 's.grade_11';
    }else{
      $strand = 's.grade_12';
    }
    $query = "SELECT s.*, CONCAT(t.name) AS strand_name ,  CONCAT(t.code) AS strand_code
    FROM student s 
    LEFT JOIN strand t ON $strand = t.id 
    WHERE s.del_status != 'deleted' AND s.grade_level = $grade
    ORDER BY s.id DESC;";
    $result = mysqli_query($conn, $query);
    ?>

    <table id="studentTable" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>LRN #</th>
          <th>Full Name</th>
          <th>Gender</th>
          <th>Email</th>
          <th>Strand</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Loop through each row from the query result and populate the table
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $gender = $row['gender'];
            $Email = $row['email'];
        ?>
        <tr>
          <td><?php echo $row['lrn'];; ?></td>
          <td><?php echo $full_name; ?></td>
          <td><?php echo $gender; ?></td>
          <td><?php echo $Email; ?></td>
          <td><?php if($row['strand_name']) {echo $row['strand_name'];}else{echo "N / A";}?></td>
          <td class="text-end">
            <a href="view.php?id=<?php echo $id; ?>&grade=<?php echo $grade;?>" class="btn btn-info btn-sm">View</a>
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
  </div>


<script src="../../assets/js/DataTables/jquery.min.js"></script>
<script src="../../assets/js/DataTables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/DataTables/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize DataTable
    $('#studentTable').DataTable({
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