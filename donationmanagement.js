$(document).ready(function () {
  let donations = [];

  function updateDashboard() {
    const totalDonations = donations.length;
    const pendingDonations = donations.filter(donation => donation.status === "Pending").length;
    $("#totalDonations").text(totalDonations);
    $("#pendingDonations").text(pendingDonations);
  }

  $("#addDonationBtn").on("click", function () {
    $("#donationModal").fadeIn();
  });

  $(".close").on("click", function () {
    $("#donationModal").fadeOut();
  });

  $("#createDonationForm").on("submit", function (e) {
    e.preventDefault();
    const donorName = $("#donorName").val();
    const donationAmount = $("#donationAmount").val();
    const donationStatus = $("#donationStatus").val();

    donations.push({ donorName, donationAmount, donationStatus });

    // Append the donation to the table
    $("#donationTable tbody").append(`
      <tr>
        <td>${donorName}</td>
        <td>$${donationAmount}</td>
        <td>${donationStatus}</td>
        <td><button class="cta-btn delete-btn">Delete</button></td>
      </tr>
    `);

    // Close modal and reset the form
    $("#donationModal").fadeOut();
    $("#createDonationForm")[0].reset();
    updateDashboard();
  });

  // Delete donation from the table
  $("#donationTable").on("click", ".delete-btn", function () {
    const rowIndex = $(this).closest("tr").index();
    donations.splice(rowIndex, 1);
    $(this).closest("tr").remove();
    updateDashboard();
  });
});
