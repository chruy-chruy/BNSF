<?php
include "../../db_conn.php"; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $grade_level = mysqli_real_escape_string($conn, $_POST['grade_level']);
    $strand = mysqli_real_escape_string($conn, $_POST['strand']);
    $section = mysqli_real_escape_string($conn, $_POST['section']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Optional: Hash the password (consider using password_hash)
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Update the student record
    $query = "UPDATE student SET 
        first_name = '$first_name',
        middle_name = '$middle_name',
        last_name = '$last_name',
        sex = '$sex',
        address = '$address',
        contact_number = '$contact_number',
        email = '$email',
        grade_level = '$grade_level',
        strand = '$strand',
        section = '$section',
        username = '$username',
        password = '$password' -- Change this to '$hashed_password' if using password_hash
        WHERE id = '$id' AND del_status != 'deleted'";

    if (mysqli_query($conn, $query)) {
        // Redirect with success message
        header("Location: index.php?success=Student updated successfully.");
    } else {
        // Redirect with error message
        header("Location: index.php?error=Failed to update student: " . mysqli_error($conn));
    }
} else {
    // Redirect to index if not a POST request
    header("Location: index.php?error=Invalid request method.");
}
?>
