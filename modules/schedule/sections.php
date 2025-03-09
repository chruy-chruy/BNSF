<?php
// Check if a message or error exists in the URL parameters
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $alertType = 'success'; // Set default alert type to 'success'
} elseif (isset($_GET['error'])) {
    $message = $_GET['error'];
    $alertType = 'danger'; // Set alert type to 'danger' for errors
}
$track = $_GET['track'];
if(isset($_GET['sy'])){
  $sy = $_GET['sy'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule Module</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- Custom Style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">
  <style>
    /* Box button design */
    .btn-box {
      display: block;
      width: 200px; /* Fixed width for all buttons */
      padding: 15px 0; /* Consistent padding */
      font-size: 18px; /* Font size */
      text-align: center; /* Center the text */
      border: 2px solid #007bff; /* Border for box design */
      border-radius: 8px; /* Rounded corners */
      transition: all 0.3s ease; /* Smooth transition for hover effect */
    }

    /* Button color */
    .btn-tvl {
      background-color: #28a745;
      color: white;
    }

    .btn-academic {
      background-color: #007bff;
      color: white;
    }

    /* Hover effect */
    .btn-box:hover {
      transform: scale(1.05); /* Slightly scale up on hover */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); /* Add shadow on hover */
    }
  </style>
</head>
<body>
<?php 
$page = 'Schedule';
include "../../db_conn.php";

$query = "SELECT * FROM `strand` WHERE track='$track' AND del_status != 'deleted'";
$result = mysqli_query($conn, $query);
?>

<!-- Sidebar -->
<?php include "../../navbar.php";?>

<!-- Main Content (Schedule Module) -->
<div class="content" id="content">
  <h1> <?php echo $track ?> Schedule</h1>
  <p>Manage the list of schedules here.</p>
  <a href="index.php" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Back
  </a>

<div style="display: flex; justify-content: flex-end; gap: 10px; align-items: center;">
    <label for="adviser">School Year:</label>
    <select name="adviser" id="adviser" class="form-select" style="max-width: 300px;" onchange="redirectToUpdate(this.value)">
        <!-- Options will be added dynamically -->
    </select>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        function populateSchoolYears() {
            const select = document.getElementById("adviser");
            const currentYear = new Date().getFullYear(); // Get current year dynamically
            const maxYears = 10; // Generate school years for the next 10 years
            const selectedYear = getQueryParam("sy"); // Get selected school year from URL
            let firstYear = ""; // Store first generated year

            for (let i = 0; i < maxYears; i++) {
                let yearStart = currentYear + i;
                let yearEnd = yearStart + 1;
                let option = document.createElement("option");
                option.value = `${yearStart}-${yearEnd}`;
                option.textContent = `${yearStart}-${yearEnd}`;

                if (i === 0) {
                    firstYear = option.value; // Store first school year
                }

                if (selectedYear === option.value) {
                    option.selected = true;
                }

                select.appendChild(option);
            }

            // If no school year is selected, default to the first option
            if (!selectedYear) {
                select.value = firstYear;
            }
        }

        populateSchoolYears(); // Call function on page load
    });

    function redirectToUpdate(sy) {
        if (sy) {
            let section = "<?php echo isset($section) ? $section : ''; ?>"; 
            let track = "<?php echo isset($track) ? $track : ''; ?>";
            let quarter = "<?php echo isset($quarter) ? $quarter : ''; ?>";

            window.location.href = `sections.php?track=${track}&quarter=${quarter}&sy=${sy}`;
        }
    }
</script>




  <!-- Schedule Module -->
  <div id="scheduleSection" class="d-flex justify-content-center align-items-center" style="height: 50vh;">
    <div class="text-center">
      <!-- Button Container -->
      <div class="d-flex justify-content-center gap-4">
      <?php 
    // Loop through each row from the query result and populate the table
    while($row = mysqli_fetch_assoc($result)) {
        $code = $row['name'];
    ?>
        <a href="grade.php?track=<?php echo $track;?>&section=<?php echo  $row['id'];?>&quarter=1&sy=<?php echo $sy;?>" class="btn btn-tvl btn-box"><?php echo $code;?></a>
        <?php }?>
      </div>
    </div>
  </div>
</div>
</body>
</html>
