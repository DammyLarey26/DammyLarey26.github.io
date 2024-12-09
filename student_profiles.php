<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profiles</title>
    <link rel="stylesheet" href="profile.css"> <!-- Link to external CSS -->

</head>
<body>

    <div class="container">
        <h1>Student Profiles</h1>

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "school_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch student profiles
        $sql = "SELECT full_name, email, phone, course, passport_photo FROM students";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='student-profile'>";
                echo "<img src='" . htmlspecialchars($row['passport_photo']) . "' alt='Passport Photo'>";
                echo "<div class='student-details'>";
                echo "<h3>" . htmlspecialchars($row['full_name']) . "</h3>";
                echo "<p><strong>Email:</strong> " . htmlspecialchars($row['email']) . "</p>";
                echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
                echo "<p><strong>Course:</strong> " . htmlspecialchars($row['course']) . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No student profiles found.</p>";
        }

        $conn->close();
        ?>

    </div>

</body>
</html>
