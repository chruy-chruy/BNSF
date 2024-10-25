<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location:../../");
    exit();
} 
include "../../db_conn.php"; // Include database connection
$nav_id = $_SESSION['id'];
$nav_query = mysqli_query($conn, "SELECT * FROM user where id = '$nav_id'");
$nav_row = mysqli_fetch_array($nav_query);


?>

<div class="sidebar" id="sidebar">
    <div>
      <img src="../../assets/img/logo.png" alt="Logo" class="logo">
    </div>
    <h6 class="text-center">Hello <?php echo $nav_row['name']; ?>! </h6>

    <a href="../dashboard" class="<?php if ($page == 'Dashboard') {echo 'active';} ?>" >Dashboard</a>
    <a href="../teacher" class="<?php if ($page == 'Teacher') {echo 'active';} ?>">Teachers</a>
    <a href="../subject" class="<?php if ($page == 'Subject') {echo 'active';} ?>">Subjects</a>
    <a href="../strand" class="<?php if ($page == 'Strand') {echo 'active';} ?>">Strands</a>
    <a href="../Student" class="<?php if ($page == 'Student') {echo 'active';} ?>">Students</a>
    <a href="../schedule" class="<?php if ($page == 'Schedule') {echo 'active';} ?>">Schedule</a>
    <a href="../grades" class="<?php if ($page == 'Grades') {echo 'active';} ?>">Grades</a>
    <?php if ($nav_row['role'] == "Super Admin") {  ?>
    <a href="../user" class="<?php if ($page == 'User') {echo 'active';} ?>">Users</a>
    <?php }?>
    <a href="../../logout.php">Logout</a>
  </div>