<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "petcare1");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Validate POST data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : null;
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;


    // Check if all fields are filled
    if ($name && $email && $password && $confirm_password) {
        // Check if passwords match
        if ($password === $confirm_password) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);


            // Check if email already exists
            $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                echo "Email already exists. Please use a different email.";
            } else {
                // Prepare and execute the insert query
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $hashed_password);


                if ($stmt->execute()) {
                    // Redirect to the same page with a query parameter to indicate success
                    header("Location: http://localhost/PetCareProject/petaccountcreating.html?signup=success");
                    exit();


                } else {
                    echo "Error: Could not register. Please try again later.";
                }
            }
        } else {
            echo "Passwords do not match.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}


$conn->close();
?>
