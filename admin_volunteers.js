document.addEventListener("DOMContentLoaded", function() {
    loadVolunteers();

    // Search functionality
    document.getElementById("search").addEventListener("input", function() {
        let search = this.value.toLowerCase();
        let rows = document.querySelectorAll("#volunteers-table tr");

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(search) ? "" : "none";
        });
    });
});

function loadVolunteers() {
    fetch("/PetCareProject/php/get_volunteers.php")
        .then(response => response.json())
        .then(data => {
            console.log("🟢 Volunteers Loaded from Backend:", data);

            const volunteers = data.volunteers || data;
            if (!Array.isArray(volunteers)) {
                console.error("❌ Error: Invalid volunteers data format!", data);
                return;
            }

            const volunteerTable = document.getElementById("volunteerList");
            if (!volunteerTable) {
                console.error("❌ Error: Volunteer table body (id='volunteerList') NOT found in HTML!");
                return;
            }

            volunteerTable.innerHTML = ""; // Clear previous data

            if (volunteers.length === 0) {
                volunteerTable.innerHTML = "<tr><td colspan='5'>No volunteers found.</td></tr>";
                return;
            }

            volunteers.forEach(volunteer => {
                let row = document.createElement("tr");
                row.innerHTML = `
                    <td>${volunteer.id}</td>
                    <td>${volunteer.name}</td>
                    <td>${volunteer.role}</td>
                    <td id="status-${volunteer.id}">${volunteer.status}</td>
                    <td id="action-${volunteer.id}">
                        ${volunteer.status === "pending" ? `
                            <button onclick="updateVolunteerStatus(${volunteer.id}, 'approved')">✅ Approve</button>
                            <button onclick="updateVolunteerStatus(${volunteer.id}, 'rejected')">❌ Reject</button>
                        ` : ""}
                    </td>
                `;
                volunteerTable.appendChild(row);
            });

            console.log("✅ Volunteers successfully displayed in Admin Panel.");
        })
        .catch(error => console.error("❌ Error loading volunteers:", error));
}


function updateVolunteerStatus(volunteerId, newStatus) {
    console.log(`🔵 Updating Volunteer ID ${volunteerId} to ${newStatus}...`);

    fetch("/PetCareProject/php/update_volunteer_status.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ volunteer_id: volunteerId, status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            console.log("✅ Volunteer status updated!");
            document.getElementById(`status-${volunteerId}`).textContent = newStatus;
            document.getElementById(`action-${volunteerId}`).innerHTML = ""; // ✅ Remove buttons after update
            alert(`✅ Volunteer ${newStatus}!`);
        } else {
            console.error("❌ Error updating volunteer:", data.message);
            alert("❌ Error: " + data.message);
        }
    })
    .catch(error => console.error("❌ Volunteer Update Error:", error));
}


