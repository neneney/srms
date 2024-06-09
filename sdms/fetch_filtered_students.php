<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

$class_code = $_POST['class_code'];
$statusFilter = $_POST['status_filter'];
$remarksFilter = $_POST['remarks_filter'];

$query = "SELECT s.studentno, s.`first-name`, s.`middle-name`, s.`last-name`, s.suffix, s.age, s.gender, ce.status, ce.remarks
          FROM class_enrollment ce
          JOIN students s ON ce.student_id = s.studentno
          WHERE ce.class_id = :class_code";

if ($statusFilter) {
    $query .= " AND ce.status = :status_filter";
}

if ($remarksFilter) {
    $query .= " AND ce.remarks = :remarks_filter";
}

$ret3 = $dbh->prepare($query);
$ret3->bindParam(':class_code', $class_code, PDO::PARAM_STR);

if ($statusFilter) {
    $ret3->bindParam(':status_filter', $statusFilter, PDO::PARAM_STR);
}

if ($remarksFilter) {
    $ret3->bindParam(':remarks_filter', $remarksFilter, PDO::PARAM_STR);
}

$ret3->execute();
$students = $ret3->fetchAll(PDO::FETCH_ASSOC);

foreach ($students as $student) {
    $fullName = htmlentities($student['first-name']) . ' ' .
        htmlentities($student['middle-name']) . ' ' .
        htmlentities($student['last-name']) . ' ' .
        htmlentities($student['suffix']);
?>
    <tr>
        <td><?php echo htmlentities($student['studentno']); ?></td>
        <td><?php echo $fullName; ?></td>
        <td><?php echo htmlentities($student['age']); ?></td>
        <td><?php echo htmlentities($student['gender']); ?></td>
        <td>
            <select class="form-control" name="status_<?php echo htmlentities($student['studentno']); ?>">
                <option value="active" <?php if ($student['status'] == 'active') echo 'selected'; ?>>Active</option>
                <option value="inactive" <?php if ($student['status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                <option value="graduated" <?php if ($student['status'] == 'graduated') echo 'selected'; ?>>Graduated</option>
                <option value="withdrawn" <?php if ($student['status'] == 'withdrawn') echo 'selected'; ?>>Withdrawn</option>
            </select>
        </td>
        <td>
            <select class="form-control" name="remarks_<?php echo htmlentities($student['studentno']); ?>">
                <option value="excellent" <?php if ($student['remarks'] == 'excellent') echo 'selected'; ?>>Excellent</option>
                <option value="good" <?php if ($student['remarks'] == 'good') echo 'selected'; ?>>Good</option>
                <option value="satisfactory" <?php if ($student['remarks'] == 'satisfactory') echo 'selected'; ?>>Satisfactory</option>
                <option value="needs improvement" <?php if ($student['remarks'] == 'needs improvement') echo 'selected'; ?>>Needs Improvement</option>
                <option value="none" <?php if ($student['remarks'] == 'none') echo 'selected' ?>>None</option>
            </select>
        </td>
    </tr>
<?php
}
?>