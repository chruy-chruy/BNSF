<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location:../../");
    exit();
} $role = $_SESSION['role'];
  
include "../../db_conn.php"; // Include database connection
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    $query = mysqli_query($conn, "SELECT * FROM student where id = '$id' AND del_status != 'deleted'");
    $row = mysqli_fetch_array($query);
}


?>

<div class="sidebar" id="sidebar">
    <div>
      <img src="../../assets/img/logo.png" alt="Logo" class="logo">
    </div>
    <h6 class="text-center">Hello <?php echo $row['first_name'] . " " . $row['last_name'] ?>! </h6>
<br>
    <a href="../dashboard" class="<?php if ($page == 'Dashboard') {echo 'active';} ?>" >Dashboard</a>
    <a href="../schedule" class="<?php if ($page == 'Schedule') {echo 'active';} ?>">My Schedule</a>
    <a href="../subject" class="<?php if ($page == 'Subject') {echo 'active';} ?>">My Grades</a>
    <a href="../../logout.php">Logout</a>
  </div>