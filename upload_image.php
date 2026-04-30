<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "petcare1");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    // Handle the file upload
    $image = $_FILES['image'];

    // Set the upload directory
    $uploadDir = 'uploads/';
    $imagePath = $uploadDir . basename($image['name']);

    // Move the uploaded file to the uploads directory
    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
        // Insert image path into the database
        $sql = "INSERT INTO rescue_requests (image_path) VALUES ('$imagePath')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Image uploaded and saved successfully.";
        } else {
            echo "Error saving image to database: " . $conn->error;
        }
    } else {
        echo "Error uploading image.";
    }
}

// Close the connection
$conn->close();
?>
