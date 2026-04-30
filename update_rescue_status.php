<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "petcare1");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["id"]) || !isset($_POST["status"])) {
        die(json_encode(["error" => "Missing POST parameters"]));
    }

    $id = intval($_POST["id"]);
    $status = $_POST["status"];

    // Update rescue status
    $stmt = $conn->prepare("UPDATE accepted_rescues SET rescue_status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Update failed: No rows affected"]);
    }

    $stmt->close();
} else {
    die(json_encode(["error" => "Invalid request method"]));
}

$conn->close();
?>
