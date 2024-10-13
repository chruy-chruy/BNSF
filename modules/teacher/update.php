<?php 
include "../../db_conn.php";

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the teacher ID
    $id = $_POST['id'];

    // Get the updated teacher data from the form
    $first_name = ucwords(trim($_POST['first_name']));
    $middle_name = ucwords(trim($_POST['middle_name']));
    $last_name = ucwords(trim($_POST['last_name']));
    $sex = $_POST['sex'];
    $contact_number = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Ensure you hash this password in a real application

    // Prepare the SQL update query
    $query = "UPDATE teacher SET 
              first_name = '$first_name',
              middle_name = '$middle_name',
              last_name = '$last_name',
              sex = '$sex',
              contact_number = '$contact_number',
              email = '$email',
              username = '$username',
              password = '$password'
              WHERE id = '$id'";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect back to the index page with a success message
        header("Location: index.php?message=Teacher updated successfully.");
        exit();
    } else {
        // Redirect back to the view page with an error message
        header("Location: view.php?id=$id&error=Failed to update teacher. Please try again.");
        exit();
    }
}

// Handle delete request if "delete" button was clicked
if (isset($_POST['delete'])) {
    // Prepare the delete query
    $deleteQuery = "UPDATE teacher SET del_status = 'deleted' WHERE id = '$id'";
    
    // Execute the delete query
    if (mysqli_query($conn, $deleteQuery)) {
        // Redirect back to the index page with a success message
        header("Location: index.php?message=Teacher deleted successfully.");
        exit();
    } else {
        // Redirect back to the view page with an error message
        header("Location: view.php?id=$id&error=Failed to delete teacher. Please try again.");
        exit();
    }
}

// Close the database connection
mysqli_close($conn);
?>
