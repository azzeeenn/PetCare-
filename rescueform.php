<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pet Rescue Management</title>
  <link rel="stylesheet" href="../css/rescue_requests.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="shortcut icon" href="http://localhost/PetCareProject/favicon.ico" type="image/x-icon">

</head>
<body>

  <header>
    <h1>Pet Rescue Management</h1>
  </header>

  <nav class="navigation">
    <a href="rescueform.php" class="active">Pet Rescue Form Details Management</a>
    <a href="admin_pets.php">Pet Adoption Management</a>
    <a href="adminadoptionprocessing.html">Pet Adoption Requests Management</a>
    <a href="admin_volunteers.html">Volunteer Management</a>
    <a href="admin_assign_task.html">Volunteer Task Management</a>
  </nav>

  <h2><center>Rescue Pet List</center></h2>

  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Location</th>
          <th>Pet Type</th>
          <th>Pet Condition</th>
          <th>Contact Name</th>
          <th>Email</th>
          <th>Phone Number</th>
          <th>Additional Info</th>
          <th>Urgency</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="rescue-list">
        <!-- Data will be inserted dynamically -->
      </tbody>
    </table>
  </div>
  <div class="button-container">
    <button class="accepted-rescues-btn" onclick="window.location.href='../accepted_rescues.php'">
      Accepted Rescue Requests
    </button>
  </div>

  <style>
    .button-container {
      text-align: center;
      margin: 20px 0;
    }

    .accepted-rescues-btn {
      background-color: #244855; /* Dark Teal */
      color: white;
      padding: 12px 20px;
      font-family: garamond;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }

    .accepted-rescues-btn:hover {
      background-color: #e64833; /* Darker Teal */
    }
  </style>

  <!-- Image Modal -->
  <div id="imageModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <img id="modal-image" src="" alt="Pet Image" style="width: 100%; max-height: 500px; object-fit: cover;">
    </div>
  </div>

  <script>
$(document).ready(function () {
    // Fetch rescue requests
    fetch("../php/fetch_rescue_requests.php") // ✅ Correct path
        .then(response => response.json())
        .then(data => {
            let tableContent = "";
            data.forEach(request => {
                tableContent += `
                    <tr data-id="${request.id}">
                        <td>${request.id}</td>
                        <td>${request.location}</td>
                        <td>${request.pet_type}</td>
                        <td>${request.pet_condition}</td>
                        <td>${request.contact_name}</td>
                        <td>${request.contact_email}</td>
                        <td>${request.contact_phone}</td>
                        <td>${request.additional_notes}</td>
                        <td>${request.urgency}</td>
                        <td>
                            <button class="view-btn" data-image="${request.pet_image}">View</button>
                        </td>
                        <td>
                            <button class="accept-btn" data-id="${request.id}">Accept</button>
                            <button class="decline-btn" data-id="${request.id}">Decline</button>
                        </td>
                    </tr>
                `;
            });
            $("#rescue-list").html(tableContent);
        })
        .catch(error => console.error("Error fetching rescue requests:", error));

    // ✅ Event delegation for dynamically loaded content
    $(document).on("click", ".view-btn", function () {
    let imageFile = $(this).data("image");

    if (imageFile) {
      let imageUrl = "/PetCareProject/uploads/" + imageFile; // Ensure correct absolute path
      console.log("Image URL:", imageUrl); // Debugging
        $("#modal-image").attr("src", imageUrl);
        $("#imageModal").fadeIn();
    } else {
        alert("No image available for this pet.");
    }
});


    // ✅ Close modal
    $(document).on("click", ".close, #imageModal", function (event) {
        if (event.target === this || $(event.target).hasClass("close")) {
            $("#imageModal").fadeOut();
        }
    });

    // ✅ Accept Rescue Request & Assign Team
    $(document).on("click", ".accept-btn", function () {
        let rescueId = $(this).data("id");

        $.ajax({
            url: "../php/accept_rescue.php", // ✅ Ensure correct path
            type: "POST",
            data: { id: rescueId },
            success: function (response) {
                if (response === "success") {
                    // Ask admin to assign a rescue team
                    assignRescueTeam(rescueId);
                    $("tr[data-id='" + rescueId + "']").fadeOut("slow", function () {
                        $(this).remove();
                    });
                } else {
                    alert("Error accepting rescue request: " + response);
                }
            },
            error: function () {
                alert("Server error while processing request.");
            }
        });
    });

    // ✅ Decline Rescue Request
    $(document).on("click", ".decline-btn", function () {
        let rescueId = $(this).data("id");

        $.ajax({
            url: "../php/decline_rescue.php", // ✅ Ensure correct path
            type: "POST",
            data: { id: rescueId },
            success: function (response) {
                if (response === "success") {
                    $("tr[data-id='" + rescueId + "']").fadeOut("slow", function () {
                        $(this).remove();
                    });
                } else {
                    alert("Error declining request.");
                }
            },
            error: function () {
                alert("Server error while processing request.");
            }
        });
    });
});

// ✅ Function to Assign a Rescue Team
function assignRescueTeam(rescueId) {
    let teamName = prompt("Enter ok for verification:");
    if (teamName) {
        $.ajax({
            url: "../php/assign_team.php",  // ✅ Correct path
            type: "POST",
            data: { rescue_id: rescueId, team_name: teamName },
            success: function (response) {
                alert(response); // Show success message
            },
            error: function () {
                alert("Server error. Could not assign team.");
            }
        });
    }
}
</script>






</body>
</html>
