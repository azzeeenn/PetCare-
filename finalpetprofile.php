<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petcare1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get the user ID from session
$user_id = $_SESSION['id'];

// Fetch pet details based on user_id
$sql = "SELECT * FROM pet_accounts WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the first pet record
    $pet = $result->fetch_assoc();
} else {
    echo "No pet details found for this user.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet Profile</title>
  <link rel="stylesheet" href="css/finalpetprofile.css">
</head>

<body>
  <!-- Navbar -->
  <nav>
    <div class="logo">
      <img src="images/logo-png-removebg-preview.png" alt="Claws and Paws Logo" style="width: 80px; height: auto;">
    </div>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="./petrackingpage.html">Pet’s Daily Care</a></li>
      <li><a href="trackingemergencycontact.html">Emergency Contact</a></li>
      <li><a href="#" id="upload-pet-images-btn">Upload Pet Images</a></li>
      <li><a href="index.html">Log Out</a></li>
    </ul>
  </nav>

  <!-- Pet Profile Header -->
  <div class="pet-profile-header">
    <h1>Pet Profile</h1>
    <img class="pet-display-image" src="images/pet-image.jpg" alt="Pet Image">
  </div>

  <!-- Profile Cards Container -->
  <div class="profile-container">
    <div class="card">
      <div class="card-inner">
        <div class="card-front">
          <h2 class="pet-name">Owner Info</h2>
        </div>
        <div class="card-back">
          <h3>Owner's Name:</h3>
          <p><?php echo $pet['owner_name']; ?></p>
          <h3>Owner's Email:</h3>
          <p><?php echo $pet['owner_email']; ?></p>
          <h3>Owner's Experience:</h3>
          <p><?php echo $pet['owner_experience']; ?></p>
          <h3>Living Situation:</h3>
          <p><?php echo $pet['living_situation']; ?></p>
          <h3>Other Pets:</h3>
          <p><?php echo $pet['other_pets']; ?></p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-inner">
        <div class="card-front">
          <h2 class="pet-name">Pet Info</h2>
        </div>
        <div class="card-back">
          <h3>Pet's Name:</h3>
          <p><?php echo $pet['pet_name']; ?></p>
          <h3>Breed:</h3>
          <p><?php echo $pet['pet_breed']; ?></p>
          <h3>Birthday:</h3>
          <p><?php echo $pet['pet_birthday']; ?></p>
          <h3>Gender:</h3>
          <p><?php echo $pet['pet_gender']; ?></p>
          <h3>Special Needs:</h3>
          <p><?php echo $pet['pet_special_needs']; ?></p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-inner">
        <div class="card-front">
          <h2 class="pet-name">Additional Info</h2>
        </div>
        <div class="card-back">
          <h3>Pet's Temperament:</h3>
          <p><?php echo $pet['pet_temperament']; ?></p>
          <h3>Favorite Activities:</h3>
          <p><?php echo $pet['pet_activities']; ?></p>
          <h3>Trained:</h3>
          <p><?php echo $pet['pet_training']; ?></p>
          <h3>Previous Ownership:</h3>
          <p><?php echo $pet['pet_previous_ownership']; ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Pet Gallery -->
  <div class="pet-gallery">
    <h2>Pet Gallery</h2>
    <div class="gallery-container">
      <!-- Display pet images if available -->
      <?php
      // Fetch pet images from database or folder
      ?>
    </div>
  </div>

  <script src="js/petprofile.js"></script>
</body>

</html>
