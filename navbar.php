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

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<div class="sidebar" id="sidebar">
<div>
    <img src="../../assets/img/logo.png" alt="Logo" class="logo">
</div>
<h6 class="text-center">Hello <?php echo $nav_row['name']; ?>! </h6>

<a href="../dashboard" class="<?php if ($page == 'Dashboard') {echo 'active';} ?>"><i class="bi bi-house-door"></i> Dashboard</a>
<a href="../teacher" class="<?php if ($page == 'Teacher') {echo 'active';} ?>"><i class="bi bi-person"></i> Teacher</a>
<a href="../subject" class="<?php if ($page == 'Subject') {echo 'active';} ?>"><i class="bi bi-book"></i> Subject</a>

<!-- Fixed Submenu for Track -->
<div class="submenu">
    <a href="#" class="<?php if ($page == 'Strand/TVL' || $page == 'Strand/Academic') {echo 'active';} ?>"><i class="bi bi-geo-alt"></i> Track</a>
    <ul>
        <li><a href="../strand?track=TVL" class="<?php if ($page == 'Strand/TVL') {echo 'active';} ?>"><i class="bi bi-card-list"></i> TVL</a></li>
        <li><a href="../strand?track=Academic" class="<?php if ($page == 'Strand/Academic') {echo 'active';} ?>"><i class="bi bi-bookmark"></i> Academic</a></li>
    </ul>
</div>

<!-- <a href="../Student" class="<?php if ($page == 'Student') {echo 'active';} ?>"><i class="bi bi-person-lines-fill"></i> Student</a> -->
<div class="submenu">
    <a href="#" class="<?php if ($page == 'Student/11' || $page == 'Student/12') {echo 'active';} ?>"><i class="bi bi-person-lines-fill"></i> Student</a>
    <ul>
        <li><a href="../Student?grade=11" class="<?php if ($page == 'Student/11') {echo 'active';} ?>"><i class="bi bi-people-fill"></i> Grade 11</a></li>
        <li><a href="../Student?grade=12" class="<?php if ($page == 'Student/12') {echo 'active';} ?>"><i class="bi bi-people-fill"></i> Grade 12</a></li>
    </ul>
</div>

<a href="../schedule" class="<?php if ($page == 'Schedule') {echo 'active';} ?>"><i class="bi bi-calendar-event"></i> Schedule</a>
<a href="../grades" class="<?php if ($page == 'Grades') {echo 'active';} ?>"><i class="bi bi-bar-chart"></i> Grade</a>

<?php if ($nav_row['role'] == "Super Admin") { ?>
    <a href="../user" class="<?php if ($page == 'User') {echo 'active';} ?>"><i class="bi bi-person-circle"></i> Users</a>
<?php } ?>

<a href="../../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>