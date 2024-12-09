<?php
// Start the session
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.html");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'school_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student data from session
$student_id = $_SESSION['student_id'];

// Query to get student information
$sql = "SELECT full_name, email, course, passport FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($full_name, $email, $course, $passport);
$stmt->fetch();
$stmt->close();

// Query to get additional student information like results, tests, assignments, etc.
$results_sql = "SELECT * FROM results WHERE student_id = ?";
$results_stmt = $conn->prepare($results_sql);
$results_stmt->bind_param("i", $student_id);
$results_stmt->execute();
$results = $results_stmt->get_result();

// Other queries can be similarly created for tests, assignments, payments, and courses

$conn->close();

// Check if all variables are set properly
if (empty($full_name) || empty($email) || empty($course) || empty($passport)) {
    echo "Error: Some student data is missing.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>

</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">TGSC</div>
        <nav>
            <ul class="nav-menu">
                <li><a href="results.php">Results</a></li>
                <li><a href="test.php">Test</a></li>
                <li><a href="assignments.php">Assignments</a></li>
                <li><a href="payment.php">Payment</a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($full_name); ?>!</h1>
        <div class="student-info">
            <div class="student-photo">
                <img src="uploads/<?php echo htmlspecialchars($passport); ?>" alt="Passport" width="150" height="150">
            </div>
            <div class="student-details">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Course:</strong> <?php echo htmlspecialchars($course); ?></p>
            </div>
        </div>

        <div class="dashboard-actions">
            <h3>Actions</h3>
            <ul>
                <li><a href="results.php">View Results</a></li>
                <li><a href="test.php">Take Test</a></li>
                <li><a href="assignments.php">Assignments</a></li>
                <li><a href="payment.php">Make Payment</a></li>
                <li><a href="courses.php">Course Information</a></li>
            </ul>
        </div>

        <h3>Your Results:</h3>
        <div class="results">
            <?php
            if ($results->num_rows > 0) {
                while ($row = $results->fetch_assoc()) {
                    echo "<p>Subject: " . htmlspecialchars($row['subject']) . " - Grade: " . htmlspecialchars($row['grade']) . "</p>";
                }
            } else {
                echo "<p>No results found.</p>";
            }
            ?>
        </div>

        <!-- You can similarly add sections for tests, assignments, payments, and courses -->
        <div class="test-info">
            <h3>Your Test Scores:</h3>
            <!-- Query for test scores and display -->
        </div>

        <div class="assignments-info">
            <h3>Your Assignments:</h3>
            <!-- Query for assignments and display -->
        </div>

        <div class="payment-info">
            <h3>Your Payment History:</h3>
            <!-- Query for payments and display -->
        </div>

        <div class="course-info">
            <h3>Your Courses:</h3>
            <!-- Query for courses and display -->
        </div>
    </div>

    <footer>
        <p>&copy; 2024 TGSC. All rights reserved.</p>
    </footer>
</body>
</html>
