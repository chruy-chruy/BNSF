<?php
          $track = $_GET['track'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Strand List</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Strand List Under Track <?php echo $track; ?> </h2>
    <table>
        <thead>
            <tr>
                <th>Track</th>
                <th>Strand</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../db_conn.php'; // Include the database connection file
            $sql = "SELECT `id`, `track`, `code`, `name`, `details`, `teacher_id`, `del_status` FROM `strand` WHERE del_status != 'deleted' AND track = '$track'";
            $result = $conn->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['track']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['details']}</td>
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
