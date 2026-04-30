$(document).ready(function () {
    // Fetch rescue requests
    function fetchRescueRequests() {
        fetch("../php/fetch_rescue_requests.php") // ✅ Corrected path
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

                // ✅ View Image Modal
                $(".view-btn").click(function () {
                    const imageUrl = $(this).data("image");
                    if (imageUrl) {
                        $("#modal-image").attr("src", imageUrl);
                        $("#imageModal").fadeIn();
                    } else {
                        alert("No image available for this pet.");
                    }
                });

                $(".close").click(function () {
                    $("#imageModal").fadeOut();
                });

                $("#imageModal").click(function (event) {
                    if (event.target === this) {
                        $(this).fadeOut();
                    }
                });

                // ✅ Accept Rescue Request
                $(".accept-btn").click(function () {
                    let requestId = $(this).data("id");

                    $.ajax({
                        url: "../php/accept_rescue.php", 
                        type: "POST",
                        data: { id: requestId },
                        success: function (response) {
                            if (response === "success") {
                                $("tr[data-id='" + requestId + "']").fadeOut("slow", function () {
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
                $(".decline-btn").click(function () {
                    let requestId = $(this).data("id");

                    $.ajax({
                        url: "../php/decline_rescue.php",
                        type: "POST",
                        data: { id: requestId },
                        success: function (response) {
                            if (response === "success") {
                                $("tr[data-id='" + requestId + "']").fadeOut("slow", function () {
                                    $(this).remove();
                                });
                            } else {
                                alert("Error declining request.");
                            }
                        }
                    });
                });
            })
            .catch(error => console.error("Error fetching rescue requests:", error));
    }

    fetchRescueRequests(); // Load data on page load
});
