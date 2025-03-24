<?php
include "../../db_conn.php"; // Ensure this file correctly connects to the database
$grade = $_GET['grade'];
// Fetch all student data
$sql = "SELECT id, lrn, first_name, middle_name, last_name, gender, age, nationality, birthday, address, contact, email, 
        mothers_name, mothers_occupation, fathers_name, fathers_occupation, strand, grade_11, grade_12, grade_level, 
        username, password, created_at FROM student 
        WHERE del_status != 'deleted' AND grade_level = '$grade'
         ORDER BY last_name, first_name";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            font-size: 10px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-left {
            text-align: left;
        }
        @media print {
            @page {
                size: A4 landscape;
                margin: 5mm;
            }
        }
    </style>
</head>
<body>
    <h2>Complete Student List</h2>
    <table>
        <thead>
            <tr>
                <th>LRN</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Grade Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $full_name = $row['last_name'] . ", " . $row['first_name'] . " " . $row['middle_name'];
                    echo "<tr>
                            <td>{$row['lrn']}</td>
                            <td class='text-left'>{$full_name}</td>
                            <td>{$row['gender']}</td>
                            <td class='text-left'>{$row['address']}</td>
                            <td>{$row['contact']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['grade_level']}</td>

                          </tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='21'>No students found.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>

<script>
    window.onload = function() {
        window.print();
        setTimeout(function() {
            window.close(); // Automatically close after printing
        }, 1000);
    };
</script>
