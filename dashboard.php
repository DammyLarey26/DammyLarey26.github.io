
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
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
        </html>

        <?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['student_id'] = $row['id'];
            echo "<h1>Welcome, " . htmlspecialchars($row['full_name']) . "!</h1>";
            echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
            echo "<p>Course: " . htmlspecialchars($row['course']) . "</p>";
            echo "<img src='" . htmlspecialchars($row['passport_photo']) . "' alt='Passport Photo' style='width:150px;'>";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that email.";
    }
}

$conn->close();
?>
