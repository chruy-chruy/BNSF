<?php
include "../../db_conn.php"; // Adjust based on your setup

$page = 'Students';
include "../../navbar_teacher.php";

if (!isset($_SESSION['id']) || !isset($_GET['student_id']) || !isset($_GET['section_id']) || !isset($_GET['grade_level']) || !isset($_GET['subject_id'])) {
    die("Unauthorized access.");
}

$teacher_id = $_SESSION['id'];
$student_id = intval($_GET['student_id']);
$section_id = intval($_GET['section_id']);
$grade_level = intval($_GET['grade_level']);
$subject_id = intval($_GET['subject_id']); // Get subject_id from the URL

// Fetch student details
$sql_student = "SELECT lrn, first_name, middle_name, last_name, gender, age FROM student WHERE id = ?";
$stmt_student = $conn->prepare($sql_student);
$stmt_student->bind_param("i", $student_id);
$stmt_student->execute();
$result_student = $stmt_student->get_result();
$student = $result_student->fetch_assoc();
$stmt_student->close();



// Fetch available semesters
$sql_semesters = "SELECT DISTINCT semester FROM schedules WHERE section = ? AND grade_level = ? ORDER BY semester ASC";
$stmt_semesters = $conn->prepare($sql_semesters);
$stmt_semesters->bind_param("ii", $section_id, $grade_level);
$stmt_semesters->execute();
$result_semesters = $stmt_semesters->get_result();
$semesters = [];
while ($row = $result_semesters->fetch_assoc()) {
    $semesters[] = $row['semester'];
}
$stmt_semesters->close();

// Fetch the schedule assigned to the teacher
$sql_schedule = "SELECT monday, tuesday, wednesday, thursday, friday FROM schedules WHERE section = ? AND grade_level = ?";
$stmt_schedule = $conn->prepare($sql_schedule);
$stmt_schedule->bind_param("ii", $section_id, $grade_level);
$stmt_schedule->execute();
$result_schedule = $stmt_schedule->get_result();

$subject_ids = [];

while ($row = $result_schedule->fetch_assoc()) {
    foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day) {
        if (!empty($row[$day])) {
            $ids = explode(',', $row[$day]); // Assuming subject IDs are stored as comma-separated values
            $subject_ids = array_merge($subject_ids, $ids);
        }
    }
}
$stmt_schedule->close();

// Remove duplicate subject IDs
$subject_ids = array_unique($subject_ids);

// Fetch subject details (Only the specific subject requested in the URL)
$subjects = [];
if (in_array($subject_id, $subject_ids)) {
    // Fetch the subject code for the specific subject_id
    $sql_subject = "SELECT id, code FROM subject WHERE id = ? AND teacher_id = ?";
    $stmt_subject = $conn->prepare($sql_subject);
    $stmt_subject->bind_param("ii", $subject_id, $teacher_id);
    $stmt_subject->execute();
    $result_subject = $stmt_subject->get_result();

    if ($row = $result_subject->fetch_assoc()) {
        $subjects[$row['id']] = $row['code'];
    }
    $stmt_subject->close();
}

// Fetch existing grades
$sql_grades = "SELECT subject_id, semester, quarter, grade FROM grades WHERE student_id = ? AND section_id = ? AND grade_level = ?";
$stmt_grades = $conn->prepare($sql_grades);
$stmt_grades->bind_param("iii", $student_id, $section_id, $grade_level);
$stmt_grades->execute();
$result_grades = $stmt_grades->get_result();
$grades = [];
while ($row = $result_grades->fetch_assoc()) {
    $grades[$row['subject_id']][$row['semester']][$row['quarter']] = $row['grade'];
}
$stmt_grades->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Grades - <?= htmlspecialchars($student['first_name']) ?></title>
  <link rel="stylesheet" href="../../assets/css/navbar.css">
  <link rel="stylesheet" href="../../assets/css/bootstrap5.3.0/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="content" id="content">
    <h2>Student Grades</h2>
    <a href="student.php?section_id=<?= $section_id ?>&grade_level=<?= $grade_level ?>" class="btn btn-secondary mb-3">Back</a>

    <!-- Display Student Details -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Student Details</h4>
            <p><strong>LRN:</strong> <?= htmlspecialchars($student['lrn']) ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($student['first_name'] . " " . $student['middle_name'] . " " . $student['last_name']) ?></p>
            <p><strong>Gender:</strong> <?= htmlspecialchars($student['gender']) ?></p>
            <p><strong>Age:</strong> <?= htmlspecialchars($student['age']) ?></p>
        </div>
    </div>

    <!-- Display Grades -->
    <?php if (!empty($subjects)): ?>
        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th rowspan="2" class="align-middle">Subject</th>
                    <?php foreach ($semesters as $semester): ?>
                        <th colspan="2">Semester <?= htmlspecialchars($semester) ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($semesters as $semester): ?>
                        <th>1st Quarter</th>
                        <th>2nd Quarter</th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject_id => $subject_code): ?>
                    <tr>
                        <td><?= htmlspecialchars($subject_code) ?></td>
                        <?php foreach ($semesters as $semester): ?>
                            <td>
                                <?php if (isset($grades[$subject_id][$semester][1])): ?>
                                    <button class="btn btn-success btn-sm add-grade" 
                                        data-subject="<?= $subject_id ?>" 
                                        data-semester="<?= $semester ?>" 
                                        data-quarter="1">
                                        <?= htmlspecialchars($grades[$subject_id][$semester][1]) ?>
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-success btn-sm add-grade" 
                                        data-subject="<?= $subject_id ?>" 
                                        data-semester="<?= $semester ?>" 
                                        data-quarter="1">
                                        Add
                                    </button>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (isset($grades[$subject_id][$semester][2])): ?>
                                    <button class="btn btn-success btn-sm add-grade" 
                                        data-subject="<?= $subject_id ?>" 
                                        data-semester="<?= $semester ?>" 
                                        data-quarter="2">
                                        <?= htmlspecialchars($grades[$subject_id][$semester][2]) ?>
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-success btn-sm add-grade" 
                                        data-subject="<?= $subject_id ?>" 
                                        data-semester="<?= $semester ?>" 
                                        data-quarter="2">
                                        Add
                                    </button>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="gradeModalLabel">Add/Edit Grade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="gradeForm">
                            <input type="hidden" name="student_id" value="<?= $student_id ?>">
                            <input type="hidden" name="section_id" value="<?= $section_id ?>">
                            <input type="hidden" name="grade_level" value="<?= $grade_level ?>">
                            <input type="hidden" name="subject_id" id="modal_subject_id">
                            <input type="hidden" name="semester" id="modal_semester">
                            <input type="hidden" name="quarter" id="modal_quarter">

                            <div class="mb-3">
                                <label for="grade" class="form-label">Grade</label>
                                <input type="number" name="grade" id="modal_grade" class="form-control" min="0" max="100" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Grade</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <p>No subjects found for this teacher.</p>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
