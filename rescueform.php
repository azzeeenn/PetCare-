<?php
$conn = new mysqli("localhost", "root", "", "petcare1");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch data from the rescue_requests table
$sql = "SELECT id, location, pet_type, pet_condition, contact_name, contact_email, contact_phone, additional_notes, urgency, pet_image FROM rescue_requests ORDER BY id DESC";
$result = $conn->query($sql);

$rescue_requests = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ensure correct image path
        if (!empty($row['pet_image']) && file_exists("uploads/" . $row['pet_image'])) {
            $row['pet_image'] = "uploads/" . $row['pet_image'];
        } else {
            $row['pet_image'] = "images/no-image.png"; // Default placeholder
        }
        $rescue_requests[] = $row;
    }
}

// Send JSON response only
header('Content-Type: application/json');
echo json_encode($rescue_requests);
exit(); // Ensure script stops execution
?>
