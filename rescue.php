<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli("localhost", "root", "", "petcare1");

    if ($conn->connect_error) {
        die('<script>alert("Database connection failed: ' . $conn->connect_error . '");</script>');
    }

    // Capture form data correctly
    $location = trim($_POST['location'] ?? '');
    $petType = trim($_POST['pet-type'] ?? '');
    $petCondition = trim($_POST['pet-condition'] ?? '');
    $contactName = trim($_POST['contact-name'] ?? ''); 
    $contactEmail = trim($_POST['contact-email'] ?? '');
    $contactPhone = trim($_POST['contact-phone'] ?? '');
    $additionalNotes = trim($_POST['additional-notes'] ?? '');
    $urgency = trim($_POST['urgency'] ?? '');

    // Validate required fields
    if (!$location || !$petType || !$petCondition || !$contactName || !$contactEmail || !$contactPhone || !$urgency) {
        echo '<script>alert("Please fill in all required fields."); window.history.back();</script>';
        exit();
    }

    // Validate email format
    if (!filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format. Please enter a valid email address."); window.history.back();</script>';
        exit();
    }

    // Validate contact number (should be 10 digits)
    if (!preg_match('/^\d{10}$/', $contactPhone)) {
        echo '<script>alert("Invalid phone number. Please enter a 10-digit number."); window.history.back();</script>';
        exit();
    }

    // Process file upload
    $uploadPath = '';
    if (isset($_FILES['pet-image']) && $_FILES['pet-image']['error'] == 0) {
        $uploadedFile = $_FILES['pet-image'];
        $uploadDir = 'uploads/'; 
        $uploadPath = $uploadDir . basename($uploadedFile['name']); 

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($uploadedFile['tmp_name'], $uploadPath)) {
            echo '<script>alert("Error uploading the file."); window.history.back();</script>';
            exit();
        }
    }

    // Insert into database with correct column names
    $stmt = $conn->prepare("INSERT INTO rescue_requests (location, pet_type, pet_condition, contact_name, contact_email, contact_phone, additional_notes, urgency, pet_image) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $location, $petType, $petCondition, $contactName, $contactEmail, $contactPhone, $additionalNotes, $urgency, $uploadPath);

    if ($stmt->execute()) {
        echo '<script>
                alert("Rescue request submitted successfully!");
                window.location.href = "index.html";
              </script>';
    } else {
        echo '<script>alert("Error: ' . $stmt->error . '");</script>';
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<script>alert("Invalid request method.");</script>';
}
?>
