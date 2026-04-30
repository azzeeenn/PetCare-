$(document).ready(function () {
  const shelters = [];
  const petsAssigned = new Set(); // To track unique pet assignments

  // Update Dashboard
  function updateDashboard() {
    $("#totalShelters").text(shelters.length);
    $("#assignedPets").text(petsAssigned.size);
  }

  // Show Modal
  $("#addShelterBtn").on("click", function () {
    $("#shelterModal").show();
  });

  // Close Modal
  $(".close").on("click", function () {
    $("#shelterModal").hide();
  });

  // Create Shelter Form
  $("#createShelterForm").on("submit", function (e) {
    e.preventDefault();
    const shelterName = $("#shelterName").val();
    const shelterLocation = $("#shelterLocation").val();
    const shelterCapacity = $("#shelterCapacity").val();
    const assignedPet = $("#assignedPet").val();

    if (assignedPet && !petsAssigned.has(assignedPet)) {
      petsAssigned.add(assignedPet);
    }

    shelters.push({ shelterName, shelterLocation, shelterCapacity, assignedPet });

    $("#shelterTable tbody").append(`
      <tr>
        <td>${shelterName}</td>
        <td>${shelterLocation}</td>
        <td>${shelterCapacity}</td>
        <td>${assignedPet}</td>
        <td><button class="cta-btn delete-btn">Delete</button></td>
      </tr>
    `);

    $("#shelterModal").hide();
    $("#createShelterForm")[0].reset();
    updateDashboard();
  });

  // Delete Shelter
  $("#shelterTable").on("click", ".delete-btn", function () {
    const rowIndex = $(this).closest("tr").index();
    const deletedShelter = shelters.splice(rowIndex, 1)[0];
    petsAssigned.delete(deletedShelter.assignedPet);
    $(this).closest("tr").remove();
    updateDashboard();
  });
});
