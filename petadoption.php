<?php
include 'db.php'; // Ensure database connection

$query = "SELECT * FROM pets";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="http://localhost/PetCareProject/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="css/petadoption.css">
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <button class="btn" onclick="openSidebar()">☰</button>
        <img src="images/logo-png-removebg-preview.png" alt="Claws and Paws Logo" id="logo">
    </div>

    <!-- Sidebar -->
    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="close-btn" onclick="closeSidebar()">×</a>
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <a href="#"><i class="fas fa-paw"></i> Adopt a Pet</a>
        <a href="#"><i class="fas fa-phone-alt"></i> Contact</a>
    </div>

    <!-- Pet Adoption Section -->
    <div class="container mt-5">
        <h2 class="headline">Find Your Furry Best Friend!</h2>
        <p class="caption">Adopt a pet and give them a forever home. Let’s make some tails wag and hearts purr!</p>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-4">
                    <div class="pet-card" onclick="window.location.href='<?php echo $row['profile_link']; ?>'">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>Age: <?php echo $row['age']; ?> years | Breed: <?php echo $row['breed']; ?></p>
                        <img src="images/adoptionanimals/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Claws and Paws. All Rights Reserved.</p>
    </footer>

    <script src="js/petadoption.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
