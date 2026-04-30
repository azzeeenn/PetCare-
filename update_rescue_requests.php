<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); // Ensure JSON response

$conn = new mysqli("localhost", "root", "", "petcare1");

// Check database connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Verify if POST data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["id"]) || !isset($_POST["status"])) {
        die(json_encode(["error" => "Missing POST parameters", "received" => $_POST]));
    }

    $id = intval($_POST["id"]);
    $status = $_POST["status"];

    if ($status == "accepted") {
        // Move the accepted request to the accepted_rescues table
        $sql = "INSERT INTO accepted_rescues (id, location, pet_type, pet_condition, contact_info, additional_notes, urgency)
                SELECT id, location, pet_type, pet_condition, contact_info, additional_notes, urgency FROM rescue_requests WHERE id = $id";
        if (!$conn->query($sql)) {
            die(json_encode(["error" => "Insert failed: " . $conn->error]));
        }

        // Send an email notification
        sendEmailNotification($id, $conn);
    }

    // Delete the request from rescue_requests table
    $delete_sql = "DELETE FROM rescue_requests WHERE id = $id";
    if ($conn->query($delete_sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        die(json_encode(["error" => "Delete failed: " . $conn->error]));
    }
} else {
    die(json_encode(["error" => "Invalid request method", "received_method" => $_SERVER["REQUEST_METHOD"]]));
}

$conn->close();

// Function to send email notification
function sendEmailNotification($id, $conn) {
    // Get the contact info (email) from the database
    $query = "SELECT contact_info FROM accepted_rescues WHERE id = $id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $to = $row['contact_info'];  // Assuming this field contains the email
        $subject = "Rescue Request Accepted!";
        $message = "Your pet rescue request has been accepted. Help is on the way!";
        $headers = "From: rescue@yourwebsite.com";

        // Send the email
        mail($to, $subject, $message, $headers);
    }
}
?>
