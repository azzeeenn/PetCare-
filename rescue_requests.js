document.addEventListener("DOMContentLoaded", function () {
    fetch("fetch_rescue_requests.php")
        .then(response => response.json())
        .then(data => {
            console.log("Fetched Data:", data); // Debugging - Check console output

            const tableBody = document.getElementById("rescue-list");
            tableBody.innerHTML = ""; // Clear table before inserting new data

            data.forEach(request => {
                const row = document.createElement("tr");

                row.innerHTML = `
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
                        <button class='accept-btn' data-id='${request.id}'>Accept</button> 
                        <button class='decline-btn' data-id='${request.id}'>Decline</button>
                    </td>
                `;

                tableBody.appendChild(row);
            });

            // Add event listeners for View buttons
            document.querySelectorAll(".view-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const imageUrl = this.getAttribute("data-image");
                    if (imageUrl) {
                        document.getElementById("modal-image").src = imageUrl;
                        document.getElementById("imageModal").style.display = "block";
                    } else {
                        alert("No image available for this pet.");
                    }
                });
            });

            // Close modal when clicking on the close button
            document.querySelector(".close").addEventListener("click", function () {
                document.getElementById("imageModal").style.display = "none";
            });

            // Close modal when clicking outside the image
            document.getElementById("imageModal").addEventListener("click", function (event) {
                if (event.target === this) {
                    this.style.display = "none";
                }
            });

        })
        .catch(error => console.error("Error fetching rescue requests:", error));
});
