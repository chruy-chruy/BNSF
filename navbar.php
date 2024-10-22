<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
} ?>

<div class="sidebar" id="sidebar">
    <div>
      <img src="../../assets/img/logo.png" alt="Logo" class="logo">
    </div>
    <h4 class="text-center">Hello : <?php echo $_SESSION['username'] ?></h4>
    <a href="../dashboard" class="<?php if ($page == 'Dashboard') {echo 'active';} ?>" >Dashboard</a>
    <a href="../teacher" class="<?php if ($page == 'Teacher') {echo 'active';} ?>">Teachers</a>
    <a href="../subject" class="<?php if ($page == 'Subject') {echo 'active';} ?>">Subject</a>
    <a href="../strand" class="<?php if ($page == 'Strand') {echo 'active';} ?>">Strand</a>
    <a href="../Student" class="<?php if ($page == 'Student') {echo 'active';} ?>">Students</a>
    <a href="../schedule" class="<?php if ($page == 'Schedule') {echo 'active';} ?>">Schedule</a>
    <a href="../grades" class="<?php if ($page == 'Grades') {echo 'active';} ?>">Grades</a>
    <a href="../../logout.php">Logout</a>
  </div>