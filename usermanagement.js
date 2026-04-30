$(document).ready(function () {
  const users = [
    { name: "John Doe", email: "john.doe@example.com", ngo: "NGO1", pet: "Pet1" },
    { name: "Jane Smith", email: "jane.smith@example.com", ngo: "NGO2", pet: "Pet2" },
    { name: "Emma Brown", email: "emma.brown@example.com", ngo: "NGO3", pet: "Pet3" }
  ];

  function updateDashboard() {
    $("#totalUsers").text(users.length);
    $("#totalNGOs").text(new Set(users.map(user => user.ngo)).size);
    const adoptedPets = users.filter(user => user.pet).map(user => user.pet);
    $("#totalAdoptedPets").text(adoptedPets.length);
  }

  function renderTable() {
    $("#userTable tbody").empty();
    users.forEach((user, index) => {
      $("#userTable tbody").append(`
        <tr>
          <td>${user.name}</td>
          <td>${user.email}</td>
          <td>${user.ngo}</td>
          <td>
            <button class="cta-btn removeBtn" data-index="${index}">Remove</button>
          </td>
        </tr>
      `);
    });
  }

  $("#addUserBtn").on("click", function () {
    $("#addUserModal").show();
  });

  $(".close").on("click", function () {
    $(".modal").hide();
  });

  $("#addUserForm").on("submit", function (e) {
    e.preventDefault();
    const name = $("#name").val();
    const email = $("#email").val();
    const ngo = $("#ngo").val();
    const pet = $("#pet").val();
    users.push({ name, email, ngo, pet });
    updateDashboard();
    renderTable();
    $(".modal").hide();
    $("#addUserForm")[0].reset();
  });

  $(document).on("click", ".removeBtn", function () {
    const index = $(this).data("index");
    users.splice(index, 1);
    updateDashboard();
    renderTable();
  });

  updateDashboard();
  renderTable();
});
