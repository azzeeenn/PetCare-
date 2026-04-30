$(document).ready(function () {
    // Assign Rescue Team
    $(".assign-btn").click(function () {
        let rescueId = $(this).data("id");
        let teamName = $(this).closest("tr").find(".assign-team").val();

        if (!teamName) {
            alert("Please select a rescue team first.");
            return;
        }

        $.ajax({
            url: "php/assign_team.php",
            type: "POST",
            data: { id: rescueId, team: teamName },
            success: function (response) {
                if (response.trim() === "success") {
                    alert("Rescue team assigned!");
                } else {
                    alert("Failed to assign team.");
                }
            },
            error: function () {
                alert("Error processing request.");
            }
        });
    });

    // Mark as Rescued
    $(document).on("click", ".rescue-complete-btn", function () {
        let rescueId = $(this).data("id");
    
        $.ajax({
            url: "php/mark_rescued.php",
            type: "POST",
            data: { id: rescueId },
            success: function (response) {
                if (response.trim() === "success") {
                    alert("Rescue marked as completed!");
                    location.reload();
                } else {
                    alert("Error marking as rescued: " + response);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("Server error occurred.");
            }
        });
    });
    
});

$(document).ready(function () {
    fetch("php/fetch_rescue_requests.php")
        .then(response => response.json())
        .then(data => {
            let tableContent = "";
            data.forEach(request => {
                let teamDisplay = request.assigned_team ? request.assigned_team : `<button class="assign-btn" data-id="${request.id}">Assign Team</button>`;
                
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
                        <td class="team-name">${teamDisplay}</td>
                    </tr>
                `;
            });
            $("#rescue-list").html(tableContent);
        })
        .catch(error => console.error("Error fetching rescue requests:", error));
});


