<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="dashboardsv.css"> <!-- Link to external CSS -->

</head>
<body>

<header>
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


    <div class="container">
        <h1>Student Dashboard</h1>
        

        <?php
        // Database connection
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
                    echo "<div class='student-profile'>";
                    echo "<img src='" . htmlspecialchars($row['passport_photo']) . "' alt='Passport Photo'>";
                    echo "<div class='student-details'>";
                    echo "<h3>" . htmlspecialchars($row['full_name']) . "</h3>";
                    echo "<p><strong>Course:</strong> " . htmlspecialchars($row['course']) . "</p>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                    echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
                    echo "<p><strong>Gender:</strong> " . htmlspecialchars($row['gender']) . "</p>";
                    echo "<p><strong>D.O.B:</strong> " . htmlspecialchars($row['dob']) . "</p>";
                    
                    
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "No account found with that email.";
            }
        }
        
        $conn->close();
        ?>
               