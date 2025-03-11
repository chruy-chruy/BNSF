<?php
// Check if a message or error exists in the URL parameters
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $alertType = 'success'; // Set default alert type to 'success'
} elseif (isset($_GET['error'])) {
    $message = $_GET['error'];
    $alertType = 'danger'; // Set alert type to 'danger' for errors
}

$section = $_GET['section'];
$quarter = $_GET['quarter'];
$track = $_GET['track'];
$grade = $_GET['grade'];
$sy = $_GET['sy'];

include "../../db_conn.php";

// Fetch section name
$query = mysqli_query($conn, "SELECT * FROM `strand` WHERE id='$section' AND del_status != 'deleted'");
$result = mysqli_fetch_array($query);
$section_name = $result['name'];

//fetch adviser name
$teacherquery = mysqli_query($conn, "SELECT * FROM `schedules` WHERE section='$section' AND grade_level='$grade' LIMIT 1");
// Check if the query returned a result
if ($teacherresult = mysqli_fetch_array($teacherquery)) {
    $teacher_id = $teacherresult['adviser'];
} else {
    $teacher_id = null; // Set a default value to avoid errors
}


// Fetch the schedule data from the schedules table for this section
$scheduleQuery = "SELECT * FROM `schedules` WHERE section = '$section' and semester = '$quarter' and grade_level = '$grade' AND school_year='$sy'";
$scheduleResult = mysqli_query($conn, $scheduleQuery);

// Fetch subjects for dropdown
$subjectsQuery = "SELECT s.* 
FROM subject s 
INNER JOIN schedule_subject ss ON ss.subject = s.id
WHERE ss.section = '$section' AND ss.semester = '$quarter'";
$subjectsResult = mysqli_query($conn, $subjectsQuery);
$subjects = [];
while($subject = mysqli_fetch_assoc($subjectsResult)) {
    $subjects[] = $subject;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule Maker</title>
  <!-- Bootstrap 5 CSS -->
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <!-- Custom Style -->
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="icon" type="image/x-icon" href="../../assets/img/logo.png">
  
  <!-- Add icon library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
  
  <style>

.modal {
            display: none;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            width: 50%;
            text-align: center;
            border-radius: 10px;
        }
        .close, .close2 {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
        }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }
    th, td {
      text-align: center;
      padding: 10px;
      border: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
    select, input[type="time"] {
      width: 100%;
    }
  </style>
</head>
<body>
<?php 
$page = 'Schedule';
include "../../navbar.php";?>

<!-- Main Content -->
<div class="content" id="content">
  <h1><?php echo $section_name . " - " . $grade; ?>  Schedule</h1>
  <p>Manage the list of schedules here.</p>
  <a href="grade.php?track=<?php echo $track; ?>&quarter=<?php echo $quarter;?>&section=<?php echo $section;?>&sy=<?php echo $sy;?>" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Back
  </a>
  
  <div class="container mt-4">

<?php if (isset($message)): ?>
<!-- Bootstrap 5 Alert -->
<div id="autoDismissAlert" class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x custom-alert" role="alert">
    <?php echo $message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

</div>

<!-- Auto-dismiss alert after 3 seconds using simple JavaScript -->
<script>
// Select the alert element
var alerts = document.getElementById('autoDismissAlert');

// Set timeout for 3 seconds (3000 ms)
if (alerts) {
    setTimeout(function() {
        // Fade out the alert (optional smooth fade out)
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';

        // After fading out, remove the alert element from the DOM
        setTimeout(function() {
            alert.remove();
        }, 500); // Remove after fade-out completes (500 ms)
    }, 3000); // 3 seconds delay
}
</script>

  <select name="quarter" id="quarter-select" onchange="goToLink()"  class="form-select" style="max-width:150px;">
            <option hidden value="<?php echo $quarter ?>">Semester <?php echo $quarter ?></option>
            <option value="./schedule.php?section=<?php echo $section?>&quarter=1&track=<?php echo $track;?>&grade=<?php echo $grade;?>&sy=<?php echo $sy;?>">Semester 1</option>
            <option value="./schedule.php?section=<?php echo $section?>&quarter=2&track=<?php echo $track;?>&grade=<?php echo $grade;?>&sy=<?php echo $sy;?>">Semester 2</option>
  </select>

  <?php
// Fetch teacher list
$teachersQuery = "SELECT id, first_name, middle_name, last_name FROM teacher WHERE del_status != 'deleted'";
$teachersResult = mysqli_query($conn, $teachersQuery);

// Generate school year options
$currentYear = date("Y");
$nextYear = $currentYear + 1;
$schoolYears = [];

for ($i = 0; $i < 5; $i++) { // Generate 5 years of options
    $schoolYears[] = ($currentYear + $i) . " - " . ($nextYear + $i);
}
?>

<div style="display: flex; justify-content: flex-end; gap: 10px; align-items: center;">
    <label for="school_year">School Year:</label>
    <input type="text" name="school_year" id="school_year" class="form-control" style="max-width: 150px;" value="<?php echo $sy?>" readonly>


    <label for="adviser">Adviser:</label>
<select name="adviser" id="adviser" class="form-select" style="max-width: 300px;" onchange="redirectToUpdate(this.value)">
    <option hidden>Select Adviser</option>
    <?php while ($teacher = mysqli_fetch_assoc($teachersResult)): ?>
        <option value="<?php echo $teacher['id']; ?>" 
            <?php echo (isset($teacher_id) && $teacher_id == $teacher['id']) ? 'selected' : ''; ?>>
            <?php echo $teacher['first_name'] . " " . $teacher['middle_name'] . " " . $teacher['last_name']; ?>
        </option>
    <?php endwhile; ?>
</select>

<script>
    function redirectToUpdate(adviserId) {
        if (adviserId) {
            let section = "<?php echo $section; ?>"; // Ensure $section is defined in your PHP
            
            // Confirmation dialog
            let confirmAction = confirm("Are you sure you want to update the adviser?");
            if (confirmAction) {
                window.location.href = `update.php?section=${section}&adviser=${adviserId}&grade=<?php echo $grade;?>&section=<?php echo $section;?>&track=<?php echo $track;?>&quarter=<?php echo $quarter;?>&sy=<?php echo $sy;?>`;
            }
        }
    }
</script>


</div>


  <script>
        function goToLink() {
            const select = document.getElementById("quarter-select");
            const url = select.value;

            if (url) {
                window.location.href = url; // Redirect to the selected link
            }
        }
    </script>
  <!-- Schedule Table -->
  <form action="save.php?teacher=<?php echo $teacher_id?>&section=<?php echo $section?>&quarter=<?php echo $quarter; ?>&track=<?php echo $track; ?>&grade=<?php echo $grade; ?>&sy=<?php echo $sy;?>" method="POST">
    <table id="scheduleTable">
      <thead>
        <tr>
          <th>Time</th>
          <th>Monday</th>
          <th>Tuesday</th>
          <th>Wednesday</th>
          <th>Thursday</th>
          <th>Friday</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($scheduleResult)): ?>
        <tr class="scheduleRow">
          <td>
            <input type="text" name="id[]" class="form-control" value="<?php echo $row['id'];?>" hidden readonly required>
            <input type="time" name="from[]" class="form-control" value="<?php echo $row['time_from']; ?>" required>
            <input type="time" name="to[]" class="form-control" value="<?php echo $row['time_to']; ?>" required>
          </td>
          <?php
          // Loop through days (Monday to Friday) and show schedule for each day
          foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day):
            $daySchedule = $row[strtolower($day)]; // Fetch the schedule value for the day
          ?>
            <td>
              <select name="schedule[<?php echo $day; ?>][]" class="form-select" required>
                <option value="" hidden><?php echo $daySchedule ?: 'Select'; ?></option>
                <option value="break" <?php echo ($daySchedule == 'break') ? 'selected' : ''; ?>>Break</option>
                <option value="lunch" <?php echo ($daySchedule == 'lunch') ? 'selected' : ''; ?>>Lunch</option>
                <?php foreach ($subjects as $subject): ?>
                  <option value="<?php echo $subject['id']; ?>" <?php echo ($daySchedule == $subject['id']) ? 'selected' : ''; ?>>
                    <?php echo $subject['code']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </td>
          <?php endforeach; ?>
          <td>
            <button type="button" class="btn btn-danger" id="deleteButton" onclick="remove('<?php echo $row['id'];?>','<?php echo $row['time_from']?>-<?php echo $row['time_to']?>')"> Delete</button>
          </td>
          
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <script>
    // Confirm before deleting
function remove(id,sched){
    const confirmed = confirm('Are you sure you want to delete this sched? ');
    if (confirmed) {
        window.location.href = 'delete.php?id='+id+'&section=<?php echo $section?>&quarter=<?php echo $quarter; ?>&track=<?php echo $track; ?>&grade=<?php echo $grade; ?>&sy=<?php echo $sy; ?>'; // Redirect to delete page
    }
};
  </script>
    
    <button type="button" id="addRowButton" class="btn btn-primary btn-add-row  mt-3">Add Row</button>
    <button type="submit" class="btn btn-success mt-3">Save Schedule</button>
  </form>
  <br><br>
<!-- end of schedule -->

<div class="row mb-3">
<div class="col-md-6">
<hr>
  <h1><?php echo $section_name . " - " . $grade; ?>  Students</h1>
  <p>Manage the list of students here.</p>
  <button id="openModal" class="btn btn-success mb-3">Add Student</button>

  <?php
  if($grade == "11"){
    $grade_level = "s.grade_11 = $section";
  }else{
    $grade_level = "s.grade_12 = $section";
  }
  
    // Query to fetch student data
    $query = "SELECT s.*, CONCAT(t.name) AS strand_name ,  CONCAT(t.code) AS strand_code
    FROM student s 
    LEFT JOIN strand t ON s.strand = t.id 
    WHERE s.del_status != 'deleted' AND $grade_level AND grade_level = '$grade'
    ORDER BY s.id DESC;";
    $result = mysqli_query($conn, $query);
    ?>

    <table id="studentTable" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>LRN #</th>
          <th>Full Name</th>
          <th>Gender</th>
          <th>Email</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Loop through each row from the query result and populate the table
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $gender = $row['gender'];
            $Email = $row['email'];
        ?>
        <tr>
          <td><?php echo $row['lrn'];; ?></td>
          <td><?php echo $full_name; ?></td>
          <td><?php echo $gender; ?></td>
          <td><?php echo $Email; ?></td>
          <td class="text-end">
            <a href="remove_student.php?id=<?php echo $row['id']; ?>&grade=<?php echo $grade;?>&section=<?php echo $section;?>&track=<?php echo $track;?>&quarter=<?php echo $quarter;?>&sy=<?php echo $sy;?>" class="btn btn-danger btn-sm">Remove</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    </div>

    <div class="col-md-6">
    <!-- subject  -->
    <hr>
  <h1><?php echo $section_name . " - " . $grade; ?>  Subjects</h1>
  <p>Manage the list of subjects here.</p>
  <button id="openModal2" class="btn btn-success mb-3">Add Subject</button>

  <?php
  
    // Query to fetch student data
    $query = "SELECT ss.*, s.code AS subject_name, CONCAT(t.last_name, ' ', t.middle_name, ' ', t.first_name) AS teacher_name
FROM schedule_subject ss
INNER JOIN subject s ON ss.subject = s.id
INNER JOIN teacher t ON s.teacher_id = t.id
WHERE ss.semester = '$quarter' AND ss.section ='$section' AND ss.school_year = '$sy' AND ss.grade_level = '$grade'";
    $result = mysqli_query($conn, $query);
    ?>

    <table id="subjectTable" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Subject Type</th>
          <th>Subject Name</th>
          <th>Teacher</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Loop through each row from the query result and populate the table
        while($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
          <td><?php echo $row['type']; ?></td>
          <td><?php echo $row['subject_name']; ?></td>
          <td><?php echo $row['teacher_name']; ?></td>
          <td class="text-end">
            <a href="delete_subject.php?id=<?php echo $row['id']; ?>&grade=<?php echo $grade;?>&section=<?php echo $section;?>&track=<?php echo $track;?>&quarter=<?php echo $quarter;?>&sy=<?php echo $sy;?>" class="btn btn-danger btn-sm">Remove</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

</div>

<div id="myModal2" class="modal">
    <div class="modal-content">
        <span class="close2">&times;</span>
        <h1>SELECT SUBJECT</h1>
        <?php
        // Query to fetch subject data along with teacher's full name
        $query = "SELECT s.*, CONCAT(t.last_name, ' ', t.middle_name, ' ', t.first_name) AS teacher_name
          FROM subject s
          INNER JOIN teacher t ON t.id = s.teacher_id
          WHERE s.del_status != 'deleted'
          AND s.grade_level = '$grade'
          AND s.id NOT IN (
              SELECT ss.subject FROM schedule_subject ss WHERE ss.section = '$section' AND ss.semester = '$quarter'
          );";
        
        $result = mysqli_query($conn, $query);
        ?>

        <table id="subjectTableModal" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Details</th>
                    <th>Teacher</th>
                    <th>Type</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['code']; ?></td>
                    <td><?php echo $row['details']; ?></td>
                    <td><?php echo $row['teacher_name']; ?></td>
                    <td>
                        <select class="form-select subject-type">
                            <option value="Applied">Applied</option>
                            <option value="Core">Core</option>
                            <option value="Specialized">Specialized</option>
                        </select>
                    </td>
                    <td class="text-end">
                        <a href="#" class="btn btn-info btn-sm add-btn"
                           data-id="<?php echo $row['id']; ?>"
                           data-grade="<?php echo $grade; ?>"
                           data-section="<?php echo $section; ?>"
                           data-track="<?php echo $track; ?>"
                           data-quarter="<?php echo $quarter; ?>"
                           data-sy="<?php echo $sy; ?>">
                           Add
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Add event listener for all "Add" buttons
    document.querySelectorAll(".add-btn").forEach(function (btn) {
        btn.addEventListener("click", function (event) {
            event.preventDefault();

            let subjectId = this.getAttribute("data-id");
            let grade = this.getAttribute("data-grade");
            let section = this.getAttribute("data-section");
            let track = this.getAttribute("data-track");
            let quarter = this.getAttribute("data-quarter");
            let sy = this.getAttribute("data-sy");

            // Get the selected type value from the corresponding row
            let selectedType = this.closest("tr").querySelector(".subject-type").value;

            // Redirect with parameters including the selected type
            window.location.href = `add_subject.php?id=${subjectId}&grade=${grade}&section=${section}&track=${track}&quarter=${quarter}&type=${selectedType}&sy=${sy}`;
        });
    });
});
</script>



<!-- modal student -->
<div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>SELECT STUDENT</h1>
          <?php
            // Query to fetch student data
            if($grade == "11"){
              $query = "SELECT * FROM student WHERE del_status = 'active' AND grade_level = '$grade' AND grade_11 = ''";
            }else{
              $query = "SELECT * FROM student WHERE del_status = 'active' AND grade_level = '$grade' AND grade_12 = ''";
            }
    // $query = "SELECT * FROM student WHERE del_status = 'active' AND grade_level = '$grade' AND $grade_level";
    $result = mysqli_query($conn, $query);
    ?>

    <table id="studentTableModal" class="table table-striped table-hover">
      <thead>
        <tr>
          <th>LRN #</th>
          <th>Full Name</th>
          <th>Gender</th>
          <th>Email</th>
          <th>Grade</th>
          <th>Strand</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Loop through each row from the query result and populate the table
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $full_name = $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'];
            $gender = $row['gender'];
            $Email = $row['email'];
        ?>
        <tr>
          <td><?php echo $row['lrn'];; ?></td>
          <td><?php echo $full_name; ?></td>
          <td><?php echo $gender; ?></td>
          <td><?php echo $Email; ?></td>
          <td><?php echo $row['grade_level'];; ?></td>
          <td>N/A</td>
          <td class="text-end">
            <a href="add.php?id=<?php echo $id; ?>&grade=<?php echo $grade;?>&section=<?php echo $section;?>&track=<?php echo $track;?>&quarter=<?php echo $quarter;?>&sy=<?php echo $sy;?>" class="btn btn-info btn-sm">Add</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
        </div>
    </div>

<script>
        const modal = document.getElementById("myModal");
        const btn = document.getElementById("openModal");
        const modal2 = document.getElementById("myModal2");
        const btn2 = document.getElementById("openModal2");
        const closeBtn = document.querySelector(".close");
        const closeBtn2 = document.querySelector(".close2");

        btn.onclick = function() {
            modal.style.display = "block";
        }
        btn2.onclick = function() {
            modal2.style.display = "block";
        }
        closeBtn.onclick = function() {
            modal.style.display = "none";
            modal2.style.display = "none";
        }

        closeBtn2.onclick = function() {
            modal2.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal || event.target == modal2) {
                modal.style.display = "none";
                modal2.style.display = "none";
            }
        }
    </script>
<!-- JavaScript to Add and Remove Rows Dynamically -->
<script>
  // Get reference to table body, add row button, and remove button
  const scheduleTableBody = document.querySelector('#scheduleTable tbody');
  const addRowButton = document.getElementById('addRowButton');

  // Event listener to add a new row
  addRowButton.addEventListener('click', () => {
    const newRow = document.createElement('tr');
    newRow.classList.add('scheduleRow');
    
    newRow.innerHTML = `
      <td> 
        <input type="text" name="id[]" class="form-control" value="0" readonly hidden required>
        <input type="time" name="from[]" class="form-control" required>
        <input type="time" name="to[]" class="form-control" required>
      </td>
      <td>
        <select name="schedule[Monday][]" class="form-select" required>
          <option value="">Select</option>
          <option value="Break">Break</option>
          <option value="Lunch">Lunch</option>
          <?php foreach ($subjects as $subject): ?>
            <option value="<?php echo $subject['id']; ?>">
              <?php echo $subject['code']; ?>
             </option>
          <?php endforeach; ?>
        </select>
      </td>
      <td>
        <select name="schedule[Tuesday][]" class="form-select" required>
          <option value="">Select</option>
          <option value="Break">Break</option>
          <option value="Lunch">Lunch</option>
           <?php foreach ($subjects as $subject): ?>
            <option value="<?php echo $subject['id']; ?>">
              <?php echo $subject['code']; ?>
             </option>
          <?php endforeach; ?>
        </select>
      </td>
      <td>
        <select name="schedule[Wednesday][]" class="form-select" required>
          <option value="">Select</option>
          <option value="Break">Break</option>
          <option value="Lunch">Lunch</option>
           <?php foreach ($subjects as $subject): ?>
            <option value="<?php echo $subject['id']; ?>">
              <?php echo $subject['code']; ?>
             </option>
          <?php endforeach; ?>
        </select>
      </td>
      <td>
        <select name="schedule[Thursday][]" class="form-select" required>
          <option value="">Select</option>
          <option value="Break">Break</option>
          <option value="Lunch">Lunch</option>
           <?php foreach ($subjects as $subject): ?>
            <option value="<?php echo $subject['id']; ?>">
              <?php echo $subject['code']; ?>
             </option>
          <?php endforeach; ?>
        </select>
      </td>
      <td>
        <select name="schedule[Friday][]" class="form-select" required>
          <option value="">Select</option>
          <option value="Break">Break</option>
          <option value="Lunch">Lunch</option>
           <?php foreach ($subjects as $subject): ?>
            <option value="<?php echo $subject['id']; ?>">
              <?php echo $subject['code']; ?>
             </option>
          <?php endforeach; ?>
        </select>
      </td>
      <td>
        <button type="button" class="btn btn-danger btn-remove-row">Remove</button>
      </td>
    `;
    scheduleTableBody.appendChild(newRow);
  });

  // Event delegation for remove button (to handle dynamically added rows)
  scheduleTableBody.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('btn-remove-row')) {
      const row = event.target.closest('tr');
      row.remove();
    }
  });
</script>
<!-- DataTable JS and Bootstrap 5 JS -->
<script src="../../assets/js/DataTables/jquery.min.js"></script>
<script src="../../assets/js/DataTables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/DataTables/dataTables.bootstrap5.min.js"></script>
<script src="../../assets/js/DataTables/bootstrap.bundle.min.js"></script>
<script>


  $(document).ready(function() {
    // Initialize DataTable
    $('#studentTableModal').DataTable({
      responsive: true // Optional: Make the table responsive
    });
    // Initialize DataTable
    $('#subjectTableModal').DataTable({
      responsive: true // Optional: Make the table responsive
    });
    $('#studentTable').DataTable({
      responsive: true // Optional: Make the table responsive
    });
    $('#subjectTable').DataTable({
      responsive: true // Optional: Make the table responsive
    });
  });
</script>

<!-- Additional CSS for DataTables -->
<style>
  .dataTables_filter {
    float: right; /* Moves the search bar to the right */
  }
</style>
</body>
</html>
