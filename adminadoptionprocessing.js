document.addEventListener("DOMContentLoaded", function () {
    loadRequests();
});

// 🟢 Function to load all adoption requests
function loadRequests() {
    fetch("../php/get_pending_requests.php")
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById("requestsTable");
            tableBody.innerHTML = ""; 

            data.forEach(request => {
                let row = document.createElement("tr");

                // Assign status colors
                let statusColor = "gray"; // Default color
                if (request.status === "Pending") statusColor = "orange";
                else if (request.status === "Interview Approved") statusColor = "blue";
                else if (request.status === "Final Approved") statusColor = "green";
                else if (request.status === "Rejected") statusColor = "red";

                row.innerHTML = `
                    <td>${request.pet_name}</td>
                    <td>${request.adopter_name}</td>
                    <td>${request.interview_slot}</td>
                    <td><span style="color:${statusColor}; font-weight:bold;">${request.status}</span></td>
                    <td>
                        <button onclick="openModal(${request.id})">View Details</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error("Error loading requests:", error));
}

let currentRequestId = null;

// 🟢 Function to open the modal with full details
document.addEventListener("DOMContentLoaded", function () {
    loadRequests();

    // Ensure modal is hidden when page loads
    document.getElementById("detailsModal").style.display = "none";

    // Close modal when clicking on the 'X'
    document.querySelector(".close").addEventListener("click", function () {
        document.getElementById("detailsModal").style.display = "none";
    });
});

function openModal(requestId) {
    currentRequestId = requestId;

    fetch(`../php/get_request_details.php?id=${requestId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error fetching request details:", data.error);
                return;
            }

            document.getElementById("modal-pet-name").textContent = data.pet_name;
            document.getElementById("modal-adopter-name").textContent = data.adopter_name;
            document.getElementById("modal-email").textContent = data.email;
            document.getElementById("modal-phone").textContent = data.phone;
            document.getElementById("modal-address").textContent = data.address;
            document.getElementById("modal-reason").textContent = data.reason;
            document.getElementById("modal-experience").textContent = data.pet_experience;
            document.getElementById("modal-alone-time").textContent = data.alone_time;
            document.getElementById("modal-commitment").textContent = data.commitment;
            document.getElementById("modal-interview-slot").textContent = data.interview_slot;

            // ✅ Show modal only when the button is clicked
            document.getElementById("detailsModal").style.display = "flex";
        })
        .catch(error => console.error("Error fetching request details:", error));
}


// 🟢 Function to update request status
function updateRequestStatus(status) {
    let notes = document.getElementById("admin-notes").value;

    console.log("Updating request ID:", currentRequestId, "New Status:", status); // Debugging

    fetch("../php/update_request_status.php", {
        method: "POST",
        body: JSON.stringify({ request_id: currentRequestId, status: status, notes: notes }),
        headers: { "Content-Type": "application/json" }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Server Response:", data); // Debugging
        if (data.message) {
            alert(data.message);
            document.getElementById("detailsModal").style.display = "none";
            loadRequests(); // ✅ Refresh table without page reload
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(error => console.error("Error updating request:", error));
}

// Reload requests with updated status
function loadRequests() {
    fetch("../php/get_pending_requests.php")
        .then(response => response.json())
        .then(data => {
            let tableBody = document.getElementById("requestsTable");
            tableBody.innerHTML = ""; 

            data.forEach(request => {
                let row = document.createElement("tr"); // ✅ Define row properly

                let statusText = request.status || "Pending"; // Default to "Pending"
                let statusColor = "gray"; 

                if (statusText === "Pending") statusColor = "orange";
                else if (statusText === "Interview Approved") statusColor = "blue";
                else if (statusText === "Final Approved") statusColor = "green";
                else if (statusText === "Rejected") statusColor = "red";

                row.innerHTML = `
                    <td>${request.pet_name}</td>
                    <td>${request.adopter_name}</td>
                    <td>${request.interview_slot}</td>
                    <td><span style="color:${statusColor}; font-weight:bold;">${statusText}</span></td>
                    <td>
                        <button onclick="openModal(${request.id})">View Details</button>
                    </td>
                `;
                tableBody.appendChild(row); // ✅ Append row to table
            });
        })
        .catch(error => console.error("Error loading requests:", error));
}





// 🟢 Functions to trigger status updates
function approveForInterview() {
    updateRequestStatus("Interview Approved");
}

function finalApprove() {
    updateRequestStatus("Final Approved");
}

function rejectRequest() {
    updateRequestStatus("Rejected");
}

// 🟢 Close modal when clicking "X"
document.querySelector(".close").addEventListener("click", function() {
    document.getElementById("detailsModal").style.display = "none";
});
