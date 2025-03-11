<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location:../../");
    exit();
} $role = $_SESSION['role'];
  
include "../../db_conn.php"; // Include database connection
if (isset($_SESSION['id'])) {
    $teacher_id = $_SESSION['id'];

    $query = mysqli_query($conn, "SELECT * FROM teacher where id = '$teacher_id' AND del_status != 'deleted'");
    $teacher_creds = mysqli_fetch_array($query);


    $adviser_query = mysqli_query($conn, "SELECT * FROM `schedules` WHERE adviser = '$teacher_id' LIMIT 1;");
    $adviser_row = mysqli_fetch_array($adviser_query);
    
}


?>

<div class="sidebar" id="sidebar">
    <div>
      <img src="../../assets/img/logo.png" alt="Logo" class="logo">
    </div>
    <h6 class="text-center">Hello <?php echo $teacher_creds['first_name'] . " " . $teacher_creds['last_name'] ?>! </h6>
<br>
    <a href="../dashboard" class="<?php if ($page == 'Dashboard') {echo 'active';} ?>" >Dashboard</a>
    <a href="../schedule" class="<?php if ($page == 'Schedule') {echo 'active';} ?>">My Schedule</a>
    <?php if($adviser_row){ ?>
    <a href="../advisory/index.php?semester=1" class="<?php if ($page == 'Advisory') {echo 'active';} ?>">My Advisory</a>
    <?php } ?>
    <a href="../student" class="<?php if ($page == 'Students') {echo 'active';} ?>">Grades</a>
    <a href="../../logout.php">Logout</a>
  </div>