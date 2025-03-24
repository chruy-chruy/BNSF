<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Teacher List</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Teacher List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Contact Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../db_conn.php'; // Include the database connection file
            
            $sql = "SELECT `id`, `id_number`, `last_name`, `middle_name`, `first_name`, `gender`, `age`, `nationality`, `birthday`, `address`, `contact`, `email`, `username`, `password`, `del_status`, `created_at` FROM `teacher` WHERE 1";
            $result = $conn->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                $full_name = $row['first_name'] . ' ' . ($row['middle_name'] ? $row['middle_name'] . ' ' : '') . $row['last_name'];
                echo "<tr>
                    <td>{$row['id_number']}</td>
                    <td>{$full_name}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['gender']}</td>
                    <td>{$row['contact']}</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
    window.onload = function() {
        window.print();
        setTimeout(function() {
            window.close(); // Automatically close the tab after printing
        }, 1000);
    };
</script>
</body>
</html>
