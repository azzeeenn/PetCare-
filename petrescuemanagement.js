$(document).ready(function () {
  let rescuePets = [];

  // Update the dashboard
  function updateDashboard() {
    const totalRescued = rescuePets.length;
    const petsNeedingCare = rescuePets.filter(pet => pet.condition !== "Healthy").length;

    $("#totalRescued").text(totalRescued);
    $("#petsNeedingCare").text(petsNeedingCare);
  }

  // Handle form submission
  $("#rescueForm").on("submit", function (e) {
    e.preventDefault();

    const petName = $("#petName").val();
    const petBreed = $("#petBreed").val();
    const petCondition = $("#petCondition").val();
    const petHistory = $("#petHistory").val();

    // Add pet to the rescue list
    rescuePets.push({ petName, petBreed, petCondition, petHistory });

    // Append the new pet to the table
    $("#rescueTable tbody").append(`
      <tr>
        <td>${petName}</td>
        <td>${petBreed}</td>
        <td>${petCondition}</td>
        <td>${petHistory}</td>
      </tr>
    `);

    // Reset the form
    $("#rescueForm")[0].reset();

    // Update the dashboard
    updateDashboard();
  });
});
