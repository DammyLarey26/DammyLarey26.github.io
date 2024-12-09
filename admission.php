<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school_db";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $course = htmlspecialchars($_POST['course']);
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);
    $raw_password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

    // Handle passport photo upload
    $target_dir = "uploads/";
    $passport_photo = $_FILES['passport_photo'];
    $target_file = $target_dir . uniqid() . "_" . basename($passport_photo['name']);
    $upload_ok = true;

    // Check if the file is an image
    $check = getimagesize($passport_photo['tmp_name']);
    if ($check === false) {
        die("File is not an image.");
    }

    // Check file size (limit: 2MB)
    if ($passport_photo['size'] > 2 * 1024 * 1024) {
        die("File is too large. Maximum size is 2MB.");
    }

    // Allow certain file formats
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($image_file_type, ['jpg', 'jpeg', 'png'])) {
        die("Only JPG, JPEG, and PNG files are allowed.");
    }

    // Move the uploaded file
    if (!move_uploaded_file($passport_photo['tmp_name'], $target_file)) {
        die("There was an error uploading the file.");
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO students (full_name, email, phone, address, course, dob, gender, password, passport_photo) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $full_name, $email, $phone, $address, $course, $dob, $gender, $hashed_password, $target_file);

    // Execute the query and check if the record was added
    if ($stmt->execute()) {
        echo "Registration successful! Welcome, " . htmlspecialchars($full_name) . ".";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
