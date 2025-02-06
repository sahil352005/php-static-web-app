<?php
// student_portal/index.php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM students WHERE id = ?");
$query->execute([$user_id]);
$student = $query->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Welcome, <?php echo htmlspecialchars($student['name']); ?>!</h2>
        <nav>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="courses.php">Courses</a></li>
                <li class="nav-item"><a class="nav-link" href="attendance.php">Attendance</a></li>
                <li class="nav-item"><a class="nav-link" href="schedule.php">Schedule</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="mt-4">
            <h3>Your Courses</h3>
            <ul>
                <?php
                $courseQuery = $conn->prepare("SELECT courses.name FROM enrollments JOIN courses ON enrollments.course_id = courses.id WHERE enrollments.student_id = ?");
                $courseQuery->execute([$user_id]);
                while ($course = $courseQuery->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li>" . htmlspecialchars($course['name']) . "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
