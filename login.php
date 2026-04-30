<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['email'], $_POST['password'])) {
        echo "Please fill in both email and password.";
        exit();
    }


    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    if (empty($email) || empty($password)) {
        echo "Please fill in both email and password.";
        exit();
    }


    $host = "localhost";
    $dbname = "petcare1";
    $username = "root";
    $dbPassword = "";


    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $dbPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);


        $query = "SELECT id, email, password, profile_completed FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];


            header("Location: " . ($user['profile_completed'] == 1 ? "finalpetprofile.php" : "petaccountcreating.html"));


            exit();
        } else {
            echo "Invalid email or password. Please try again.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
?>
