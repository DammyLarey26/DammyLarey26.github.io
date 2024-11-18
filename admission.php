<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP (leave empty)
$dbname = "school_db"; // Replace with your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $course = $_POST['course'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    // Prepare an SQL statement to insert the data
    $sql = "INSERT INTO students (full_name, email, phone, address, course, dob, gender) 
            VALUES ('$full_name', '$email', '$phone', '$address', '$course', '$dob', '$gender')";

    // Execute the query and check if the record was added
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! Welcome, " . htmlspecialchars($full_name) . ".";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
