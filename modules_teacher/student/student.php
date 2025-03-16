<?php
include "../../db_conn.php"; // Database connection
$page = 'Students';
include "../../navbar_teacher.php";


$teacher_id = $_SESSION['id'];
$section_id = intval($_GET['section_id']);
$subject_id = intval($_GET['subject_id']);
$subject_name = $_GET['subject_name'];
$selected_grade_level = isset($_GET['grade_level']) ? intval($_GET['grade_level']) : null;

// Check if there are 2 semesters
$sql_semseter = "SELECT `id`, `section`, `subject`, `type`, `semester`, `school_year`, `grade_level` 
                 FROM `schedule_subject` 
                 WHERE section = ? AND subject = ? 
                 ORDER BY semester DESC";
$stmt_semseter = $conn->prepare($sql_semseter);
$stmt_semseter->bind_param("ii", $section_id, $subject_id);
$stmt_semseter->execute();
$result_semseter = $stmt_semseter->get_result();

// Check if there is more than one result (i.e., more than one semester)
if ($result_semseter->num_rows > 1) {
    $check_semester = true;
    
// Define selected semester based on the URL parameter (default to 1 if not set)
$selected_semester = isset($_GET['semester']) ? intval($_GET['semester']) : 1;
} else {
    $check_semester = false;
    if ($row = $result_semseter->fetch_assoc()) {
        $semester = $row['semester']; // Fetch semester value from the first row
        
// Define selected semester based on the URL parameter (default to 1 if not set)
$selected_semester = $row['semester']; 
    }
}

// Get section name
$sql_section_name = "SELECT name FROM strand WHERE id = ?";
$stmt_section_name = $conn->prepare($sql_section_name);
$stmt_section_name->bind_param("i", $section_id);
$stmt_section_name->execute();
$result_section_name = $stmt_section_name->get_result();
$section = $result_section_name->fetch_assoc()['name'] ?? "Unknown Section";
$stmt_section_name->close();

if($selected_grade_level == '11'){
  $where_grade11 = 'grade_11';
}else{
  $where_grade11 = 'grade_12';
}
// Fetch students in the section
$sql_students = "SELECT id, first_name, middle_name, last_name FROM student WHERE $where_grade11 = ? AND grade_level = ?";
$stmt_students = $conn->prepare($sql_students);
$stmt_students->bind_param("ii", $section_id,$selected_grade_level);
$stmt_students->execute();
$result_students = $stmt_students->get_result();

// Function to fetch grades (Prevents redeclaration)
if (!function_exists('getGrade')) {
    function getGrade($conn, $student_id, $section_id, $subject_id, $semester, $quarter) {
        $sql_grades = "SELECT grade FROM grades WHERE student_id = ? AND section_id = ? AND subject_id = ? AND semester = ? AND quarter = ?";
        $stmt_grades = $conn->prepare($sql_grades);
        $stmt_grades->bind_param("iiiii", $student_id, $section_id, $subject_id, $semester, $quarter);
        $stmt_grades->execute();
        $result_grades = $stmt_grades->get_result();
        return $result_grades->fetch_assoc()['grade'] ?? '';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Dashboard - <?= htmlspecialchars($section) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
      .schedule-header {
      text-align: center;
      margin-bottom: 20px;
    }
</style>
</head>
<body>

<div class="content">
<div class="schedule-header">
      <h2>Grades</h2>
</div>
    <a href="index.php" class="btn btn-secondary mb-3">Back</a>

    <br>
    <div class="row mb-1">
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="student_name" class="form-label m-0" style="white-space: nowrap;">Subject Name:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="student_name" 
               value="<?= htmlspecialchars($subject_name) ?>" readonly>
    </div>
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="section_name" class="form-label m-0" style="white-space: nowrap;">Grade Level:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="section_name" 
               value="<?= htmlspecialchars($selected_grade_level) ?>" readonly>
    </div>
</div>

<div class="row mb-1">
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="student_lrn" class="form-label m-0" style="white-space: nowrap;">Section Name:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="student_lrn" 
               value="<?= htmlspecialchars($section) ?>" readonly>
    </div>
    <div class="col-md-6 d-flex align-items-center gap-2">
        <label for="grade_level" class="form-label m-0" style="white-space: nowrap;">Semester:</label>
        <input type="text" class="form-control form-control-sm bg-transparent border-0" id="grade_level" 
               value="<?= htmlspecialchars($selected_semester) ?>" readonly>
    </div>
</div>
<hr>

<div class="semester-buttons mb-3">
    <?php if ($result_semseter->num_rows == 1) {
    ?>
        <a href="?section_id=<?= $section_id ?>&subject_id=<?= $subject_id ?>&subject_name=<?= $subject_name ?>&grade_level=<?= $selected_grade_level ?>&semester=<?= $semester ?>" 
           class="btn btn-primary">Semester <?= $semester ?></a>
    <?php } else { ?>
        <a href="?section_id=<?= $section_id ?>&subject_id=<?= $subject_id ?>&subject_name=<?= $subject_name ?>&grade_level=<?= $selected_grade_level ?>&semester=1" 
           class="btn <?= ($selected_semester == 1) ? 'btn-primary' : 'btn-info' ?>">Semester 1</a>

        <a href="?section_id=<?= $section_id ?>&subject_id=<?= $subject_id ?>&subject_name=<?= $subject_name ?>&grade_level=<?= $selected_grade_level ?>&semester=2" 
           class="btn <?= ($selected_semester == 2) ? 'btn-primary' : 'btn-info' ?>">Semester 2</a>
    <?php } ?>
</div>




    <?php if ($result_students->num_rows > 0): ?>
      <table id="studentTable" class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Name of Students</th>
            <th>1st Quarter</th>
            <th>2nd Quarter</th>
            <th>Final Grade</th>
            <th>Remarks</th>
          </tr>
        </thead>
        <tbody>
          <?php $count = 1; while ($row = $result_students->fetch_assoc()) : ?>
            <tr>
              <td><?= $count++ ?></td>
              <td><?= htmlspecialchars($row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']) ?></td>
              
              <?php 
              $first_quarter = getGrade($conn, $row['id'], $section_id, $subject_id, $selected_semester, 1);
              $second_quarter = getGrade($conn, $row['id'], $section_id, $subject_id, $selected_semester, 2);
              $fg = ($first_quarter !== '' && $second_quarter !== '') ? round(($first_quarter + $second_quarter) / 2) : '';

              $remarks = ($fg >= 75) ? 'PASSED' : 'FAILED';
              if($fg === ''){
                $remarks = '';
              }
              ?>

<!-- <td>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editGradeModal"
        data-student-id="<?= $row['id'] ?>" data-quarter="1" data-grade="<?= $first_quarter ?>"
        data-subject-id="<?= $subject_id ?>" data-grade-level="<?= $selected_grade_level ?>" data-semester="<?= $selected_semester ?>">
        <?= $first_quarter !== '' ? htmlspecialchars($first_quarter) : '-' ?>
    </button>
</td>

<td>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editGradeModal"
        data-student-id="<?= $row['id'] ?>" data-quarter="2" data-grade="<?= $second_quarter ?>"
        data-subject-id="<?= $subject_id ?>" data-grade-level="<?= $selected_grade_level ?>" data-semester="<?= $selected_semester ?>">
        <?= $second_quarter !== '' ? htmlspecialchars($second_quarter) : '-' ?>
    </button>
</td> -->

<td>
    <input type="number" class="form-control grade-input" 
        data-student-id="<?= $row['id'] ?>" 
        data-quarter="1" 
        data-subject-id="<?= $subject_id ?>" 
        data-grade-level="<?= $selected_grade_level ?>" 
        data-semester="<?= $selected_semester ?>"
        data-section-id="<?= $section_id ?>"
        value="<?= $first_quarter !== '' ? htmlspecialchars($first_quarter) : '' ?>" 
        min="0" max="100">
</td>

<td>
    <input type="number" class="form-control grade-input" 
        data-student-id="<?= $row['id'] ?>" 
        data-quarter="2" 
        data-subject-id="<?= $subject_id ?>" 
        data-grade-level="<?= $selected_grade_level ?>" 
        data-semester="<?= $selected_semester ?>"
        data-section-id="<?= $section_id ?>"
        value="<?= $second_quarter !== '' ? htmlspecialchars($second_quarter) : '' ?>" 
        min="0" max="100">
</td>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.grade-input').forEach(input => {
        input.addEventListener('change', function () {
            let studentId = this.dataset.studentId;
            let quarter = this.dataset.quarter;
            let subjectId = this.dataset.subjectId;
            let gradeLevel = this.dataset.gradeLevel;
            let semester = this.dataset.semester;
            let sectionId = this.dataset.sectionId;
            let grade = this.value;
            
            // Ensure grade is within valid range
            if (grade < 0 || grade > 100) {
                alert('Grade must be between 0 and 100.');
                this.value = ''; // Reset input
                return;
            }

            let formData = new FormData();
            formData.append('student_id', studentId);
            formData.append('quarter', quarter);
            formData.append('subject_id', subjectId);
            formData.append('grade_level', gradeLevel);
            formData.append('semester', semester);
            formData.append('grade', grade);
            formData.append('section_id', sectionId);


            fetch(`update_grade.php`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            location.reload();
            alert(data);
        })
        .catch(error => console.error('Error:', error));
    });
    });
});
</script>


<td><?= ($fg !== '') ? htmlspecialchars($fg) : '-' ?></td>

              <td class="<?= $remarks == 'FAILED' ? 'text-danger' : 'text-success' ?>"><strong><?= $remarks ?></strong></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No students found in Grade <?= $selected_grade_level ?> for this section.</p>
    <?php endif; ?>
</div>

<!-- Modal for Editing Grades -->
<!-- <div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editGradeLabel">Edit Grade</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="updateGradeForm">
          <input type="hidden" id="studentId" name="student_id">
          <input type="hidden" id="quarter" name="quarter">
          <input type="hidden" id="subjectId" name="subject_id">
          <input type="hidden" id="gradeLevel" name="grade_level">
          <input type="hidden" id="sectionId" name="section_id">
          <input type="hidden" id="semester" name="semester">
          
          <div class="mb-3">
            <label for="gradeInput" class="form-label">Grade</label>
            <input type="number" class="form-control" id="gradeInput" name="grade" min="0" max="100">
            <script>document.getElementById('gradeInput').addEventListener('input', function (e) {
    this.value = this.value.replace(/\D/g, '').slice(0, 3); // Allows only numbers, max 13 digits
});</script>
          </div>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editGradeModal = document.getElementById('editGradeModal');
    
    editGradeModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        
        document.getElementById('studentId').value = button.getAttribute('data-student-id');
        document.getElementById('quarter').value = button.getAttribute('data-quarter');
        document.getElementById('gradeInput').value = button.getAttribute('data-grade');
        document.getElementById('subjectId').value = button.getAttribute('data-subject-id');
        document.getElementById('gradeLevel').value = button.getAttribute('data-grade-level');
        document.getElementById('semester').value = button.getAttribute('data-semester');

        // Get section_id from URL and set it in the form
        var urlParams = new URLSearchParams(window.location.search);
        document.getElementById('sectionId').value = urlParams.get('section_id');
        // document.getElementById('semester').value = urlParams.get('semester');
    });

    document.getElementById('updateGradeForm').addEventListener('submit', function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        fetch(`update_grade.php`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    });
}); -->

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
