<?php
session_start();

include('../includes/config.php');

// Keep the existing admin login flow, but prevent accidental access when no admin session exists.
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

// Delete a student from the table.
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $studentId = trim($_GET['id']);

    if ($studentId !== '') {
        $stmt = mysqli_prepare($database, "DELETE FROM Student WHERE Enrollment_No = ?");
        mysqli_stmt_bind_param($stmt, 's', $studentId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['msgr'] = 'Student deleted successfully.';
    }

    header('Location: admin_panel.php');
    exit;
}

// Load all students for the admin table.
$students = mysqli_query(
    $database,
    "SELECT Enrollment_No, First_Name, Last_Name, Department, Subject_1 FROM Student ORDER BY Enrollment_No ASC"
);

if (!$students) {
    die('Unable to load students: ' . htmlspecialchars(mysqli_error($database)));
}

$message = $_SESSION['msgr'] ?? '';
unset($_SESSION['msgr']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Student List</title>
    <link rel="stylesheet" href="panel.css">
</head>
<body>
    <main class="admin-shell">
        <section class="student-card">
            <div class="card-header">
                <div>
                    <h1>Student List</h1>
                    <p>Manage registered students</p>
                </div>
                <a class="add-button" href="newstudent.php">+ Add New Student</a>
            </div>

            <?php if ($message !== ''): ?>
                <div class="alert success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div class="table-wrap">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>EMAIL / DEPT</th>
                            <th>COURSE</th>
                            <th>STUDENTID</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($students)):
                        $firstName = trim((string)($row['First_Name'] ?? ''));
                        $lastName = trim((string)($row['Last_Name'] ?? ''));
                        $name = trim($firstName . ' ' . $lastName);
                        $name = $name !== '' ? $name : 'N/A';

                        $department = trim((string)($row['Department'] ?? ''));
                        $department = $department !== '' ? $department : '-';

                        // The current database does not have a separate Course column.
                        // Use the alphabetic prefix of the enrollment number (e.g. CRM123 -> CRM).
                        $enrollment = trim((string)$row['Enrollment_No']);
                        preg_match('/^[A-Za-z]+/', $enrollment, $courseMatch);
                        $course = isset($courseMatch[0]) && $courseMatch[0] !== ''
                            ? strtoupper($courseMatch[0])
                            : '-';
                    ?>
                        <tr>
                            <td data-label="ID"><?php echo $count; ?></td>
                            <td data-label="NAME"><?php echo htmlspecialchars($name); ?></td>
                            <td data-label="EMAIL / DEPT"><?php echo htmlspecialchars($department); ?></td>
                            <td data-label="COURSE"><?php echo htmlspecialchars($course); ?></td>
                            <td data-label="STUDENTID"><?php echo htmlspecialchars($enrollment); ?></td>
                            <td data-label="ACTION" class="actions">
                                <a class="edit-link" href="edit/view.php?id=<?php echo rawurlencode($enrollment); ?>">Edit</a>
                                <span class="divider">|</span>
                                <a
                                    class="delete-link"
                                    href="admin_panel.php?delete=1&amp;id=<?php echo rawurlencode($enrollment); ?>"
                                    onclick="return confirm('Are you sure you want to delete this student?');"
                                >Delete</a>
                            </td>
                        </tr>
                    <?php
                        $count++;
                    endwhile;
                    ?>
                    </tbody>
                </table>

                <?php if ($count === 1): ?>
                    <div class="empty-state">
                        <h2>No students found</h2>
                        <p>Click <strong>+ Add New Student</strong> to create the first student.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="card-footer">
                <a href="add_course.php" class="secondary-button">Add Course</a>
                <a href="courses/edit.php" class="secondary-button">Manage Courses</a>
                <a href="../" class="secondary-button">Student Login</a>
            </div>
        </section>
    </main>
</body>
</html>
