<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Subject List</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Subject List</h2>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Details</th>
                <th>Teacher Name</th>
                <th>Grade Level</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../../db_conn.php'; // Include the database connection file
            $grade = $_GET['grade'];
            $sql = "  SELECT s.*, CONCAT(t.first_name, ' ', t.last_name) AS teacher_name 
         FROM subject s 
         LEFT JOIN teacher t ON s.teacher_id = t.id 
         WHERE s.del_status != 'deleted'AND s.grade_level = '$grade'
         ORDER BY s.id DESC;";
            $result = $conn->query($sql);
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['code']}</td>
                    <td>{$row['details']}</td>
                    <td>{$row['teacher_name']}</td>
                    <td>{$row['grade_level']}</td>
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
