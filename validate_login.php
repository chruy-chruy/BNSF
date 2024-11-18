<?php
session_start();
include "db_conn.php";

echo $_POST['username'] . $_POST['password'];

if (isset($_POST['username']) && isset($_POST['password'])) {

    //validate and make data secured in sql injection
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);
    $role = validate($_POST['role']);

    if (empty($uname)) {
        header("Location: index.php?error=Username is required.");
        exit();
    } else if (empty($pass)) {
        header("Location: index.php?error=Password is required.");
        exit();
    } else if($role == "registrar") {
        $sql = "SELECT * FROM user WHERE username='$uname' AND password='$pass'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $uname && $row['password'] === $pass) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['name'] = $row['name'];
                header("Location: modules/dashboard/");
                exit();
            }
            else{
                header("Location: index.php?error=Incorrect username or password.");
            exit();
            }
        } else {
            header("Location: index.php?error=Incorrect username or password.");
            exit();
        }
    }else if($role == "student") {
        $sql = "SELECT * FROM student WHERE username='$uname' AND password='$pass' AND del_status != 'deleted'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $uname && $row['password'] === $pass) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $role;
                header("Location: modules_student/dashboard/");
                exit();
            }
            else{
                header("Location: index.php?error=Incorrect username or password.");
            exit();
            }
        } else {
            header("Location: index.php?error=Incorrect username or password.");
            exit();
        }
    }else if($role == "teacher") {
        $sql = "SELECT * FROM teacher WHERE username='$uname' AND password='$pass' AND del_status != 'deleted'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $uname && $row['password'] === $pass) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $role;
                header("Location: modules_teacher/dashboard/");
                exit();
            }
            else{
                header("Location: index.php?error=Incorrect username or password.");
            exit();
            }
        } else {
            header("Location: index.php?error=server error.");
            exit();
        }
    }
    else{
        $sql = "SELECT * FROM user WHERE username='$uname' AND password='$pass'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $uname && $row['password'] === $pass) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                header("Location: modules/dashboard/");
                exit();
            }
            else{
                header("Location: index.php?error=Incorrect username or password.");
            exit();
            }
        } else {
            header("Location: index.php?error=Incorrect username or password.");
            exit();
        }
    }
}