<?php
session_start();

$servername = "localhost"; // Your database host (usually 'localhost')
$username = "root"; // Your database username
$password = ""; // Your database password (empty for default MySQL setup)
$dbname = "petcare1"; // Replace with your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User ID not found in session.";
    exit();  // Stop further execution if session is not set
}

$user_id = $_SESSION['user_id']; // Assign user_id from session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $owner_email = mysqli_real_escape_string($conn, $_POST['owner_email']);
    $owner_experience = mysqli_real_escape_string($conn, $_POST['owner_experience']);
    $living_situation = mysqli_real_escape_string($conn, $_POST['living_situation']);
    $other_pets = mysqli_real_escape_string($conn, $_POST['other_pets']);
    $pet_name = mysqli_real_escape_string($conn, $_POST['pet_name']);
    $pet_breed = mysqli_real_escape_string($conn, $_POST['pet_breed']);
    $pet_birthday = mysqli_real_escape_string($conn, $_POST['pet_birthday']);
    $pet_gender = mysqli_real_escape_string($conn, $_POST['pet_gender']);
    $pet_temperament = mysqli_real_escape_string($conn, $_POST['pet_temperament']);
    $pet_activities = mysqli_real_escape_string($conn, $_POST['pet_activities']);
    $pet_training = mysqli_real_escape_string($conn, $_POST['pet_training']);

    // Insert into pet account table
    $sql = "INSERT INTO pet_accounts (user_id, pet_name, pet_breed, pet_birthday, pet_gender, pet_temperament, pet_activities, pet_training)
            VALUES ('$user_id', '$pet_name', '$pet_breed', '$pet_birthday', '$pet_gender', '$pet_temperament', '$pet_activities', '$pet_training')";

    if (mysqli_query($conn, $sql)) {
        // Debugging: Check that the query is successful
        echo "Pet account inserted successfully.<br>";

        // Update profile completion status in users table
        $update_sql = "UPDATE users SET profile_completed = 1 WHERE id = '$user_id'";

        if (mysqli_query($conn, $update_sql)) {
            // Redirect to dashboard or profile page after successful completion
            header("Location: finalpetprofile.html");
            exit();
        } else {
            echo "Error updating profile completion: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting pet account: " . mysqli_error($conn);
    }
}
?>
