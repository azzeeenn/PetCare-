<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petcare1";

// ✅ Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Fetch Pets
$sql = "SELECT pets.pet_id, pets.name, pets.age, pets.breed, 
        pet_details.gender, pet_details.color, pet_details.weight, 
        pet_details.current_location, pet_details.price, 
        pet_details.image, pet_details.gallery_img1, pet_details.gallery_img2, pet_details.gallery_img3 
        FROM pets 
        JOIN pet_details ON pets.pet_id = pet_details.pet_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Pets</title>

    <!-- ✅ Bootstrap & Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin_pets.css">
    <link rel="shortcut icon" href="http://localhost/PetCareProject/favicon.ico" type="image/x-icon">

    
    <!-- ✅ jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- ✅ Header -->
<header>
    <h1>Pet Adoption Management</h1>
</header>

<!-- ✅ Navigation -->
<nav class="navigation">
        <a href="../adminside/rescueform.php">Pet Rescue Form Details Management</a>
        <a href="../adminside/admin_pets.php" class="active">Pet Adoption Management</a>
        <a href="../adminside/adminadoptionprocessing.html" >Pet Adoption Requests Management</a>
        <a href="../adminside/admin_volunteers.html" >Volunteer Management</a>
        <a href="../adminside/admin_assign_task.html" >Volunteer task Management</a>
    </nav>

<!-- ✅ Page Content -->
<div class="container mt-5">
    <h2>Manage Pets</h2>

    <!-- ✅ "Add New Pet" Button -->
    <center>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#petModal">
            Add New Pet
        </button>
    </center>

    <!-- ✅ Pet List Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Breed</th>
                <th>Gender</th>
                <th>Color</th>
                <th>Weight</th>
                <th>Location</th>
                <th>Price</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="petList">
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['age'] ?></td>
                <td><?= $row['breed'] ?></td>
                <td><?= $row['gender'] ?></td>
                <td><?= $row['color'] ?></td>
                <td><?= $row['weight'] ?> kg</td>
                <td><?= $row['current_location'] ?></td>
                <td>₹<?= $row['price'] ?></td>
                <td><img src="<?= $row['image'] ?>" width="50"></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editPet(<?= htmlspecialchars(json_encode($row)) ?>)">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deletePet(<?= $row['pet_id'] ?>)">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- ✅ Add/Edit Pet Modal -->
<div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content p-3" style="background: #FBE9D0; border-radius: 15px;">
      <div class="modal-header" style="border-bottom: none;">
        <h4 class="modal-title" id="petModalLabel" style="color: #244855; font-weight: bold;">Add Pet</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="managePetForm" enctype="multipart/form-data">
          <input type="hidden" id="pet_id" name="pet_id">

          <div class="row">
            <div class="col-md-6">
              <input type="text" id="name" name="name" class="form-control mb-3" placeholder="Pet Name" required>
              <input type="number" id="age" name="age" class="form-control mb-3" placeholder="Age" required>
              <input type="text" id="breed" name="breed" class="form-control mb-3" placeholder="Breed" required>
              <input type="text" id="gender" name="gender" class="form-control mb-3" placeholder="Gender" required>
              <input type="text" id="color" name="color" class="form-control mb-3" placeholder="Color" required>
            </div>
            <div class="col-md-6">
              <input type="number" id="weight" name="weight" class="form-control mb-3" placeholder="Weight (kg)" step="0.1" required>
              <input type="text" id="current_location" name="current_location" class="form-control mb-3" placeholder="Location" required>
              <input type="number" id="price" name="price" class="form-control mb-3" placeholder="Price (₹)" required>
              <label>Main Image:</label>
              <input type="file" id="image" name="image" class="form-control">
              <input type="hidden" id="existing_image" name="existing_image">

            </div>
          </div>

          <label class="mt-3">Gallery Images:</label>
          <div class="d-flex gap-2">
            <input type="file" id="gallery_img1" name="gallery_img1" class="form-control">
            <input type="file" id="gallery_img2" name="gallery_img2" class="form-control">
            <input type="file" id="gallery_img3" name="gallery_img3" class="form-control">
<input type="hidden" id="existing_gallery_img1" name="existing_gallery_img1">
<input type="hidden" id="existing_gallery_img2" name="existing_gallery_img2">
<input type="hidden" id="existing_gallery_img3" name="existing_gallery_img3">

          </div>

          <div class="modal-footer mt-3" style="border-top: none;">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function editPet(pet) {
    $('#petModal').modal('show');

    document.getElementById("pet_id").value = pet.pet_id;
    document.getElementById("name").value = pet.name;
    document.getElementById("age").value = pet.age;
    document.getElementById("breed").value = pet.breed;
    document.getElementById("gender").value = pet.gender;
    document.getElementById("color").value = pet.color;
    document.getElementById("weight").value = pet.weight;
    document.getElementById("current_location").value = pet.current_location;
    document.getElementById("price").value = pet.price;

    // ✅ Ensure existing image paths are retained
    document.getElementById("existing_image").value = pet.image;
    document.getElementById("existing_gallery_img1").value = pet.gallery_img1;
    document.getElementById("existing_gallery_img2").value = pet.gallery_img2;
    document.getElementById("existing_gallery_img3").value = pet.gallery_img3;

    console.log("📸 Existing Image Retained:", document.getElementById("existing_image").value);
}

function deletePet(pet_id) {
            if (confirm("Are you sure you want to delete this pet?")) {
                $.post("/PetCareProject/php/delete_pet.php", { pet_id: pet_id }, function(response) {
                    if (response.trim() === "Success") {
                        alert("Pet deleted successfully!");
                        location.reload();
                    } else {
                        alert("Error deleting pet: " + response);
                    }
                }).fail(function(xhr, status, error) {
                    alert("Failed to delete pet. Error: " + error);
                });
            }
        }

        $("#managePetForm").submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    console.log("🚀 Sending Form Data:");
    for (let pair of formData.entries()) {
        console.log(pair[0] + ": " + pair[1]);  // ✅ Debugging form data
    }

    $.ajax({
        url: "/PetCareProject/php/save_pet.php",
        type: "POST",
        data: formData,
        processData: false,  
        contentType: false,  
        success: function(response) {
            console.log("✅ Server Response:", response);
            alert(response);
            if (response.includes("successfully")) {
                location.reload();
            } else {
                alert("❌ Error: " + response);
            }
        },
        error: function(xhr, status, error) {
            console.error("❌ AJAX Error:", status, error);
            alert("AJAX Request Failed!\nStatus: " + status + "\nError: " + error);
        }
    });
});





</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
