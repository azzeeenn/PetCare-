document.addEventListener("DOMContentLoaded", function () {
    loadVolunteers();
    loadTasks();

    document.getElementById("assignTaskForm").addEventListener("submit", function (event) {
        event.preventDefault();
        assignTask();
    });
});

// ✅ Load Volunteers
function loadVolunteers() {
    fetch("/PetCareProject/php/get_volunteers.php")
        .then(response => response.json())
        .then(data => {
            const volunteerSelect = document.getElementById("volunteer");
            volunteerSelect.innerHTML = "<option value=''>Select Volunteer</option>";
            data.volunteers.forEach(volunteer => {
                let option = document.createElement("option");
                option.value = volunteer.id;
                option.textContent = `${volunteer.name} (${volunteer.role})`;
                volunteerSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Error loading volunteers:", error));
}

function loadTasks() {
    fetch("/PetCareProject/php/get_tasks.php")
        .then(response => response.json())
        .then(data => {
            console.log("🟢 Tasks Loaded from Backend:", data); // ✅ Debugging

            const taskList = document.getElementById("taskList");
            if (!taskList) {
                console.error("❌ Error: Task list table body not found!");
                return;
            }

            taskList.innerHTML = ""; // Clear previous tasks

            // ✅ Fix: Ensure tasks exist before trying to loop
            const tasks = data.tasks || [];
            if (tasks.length === 0) {
                taskList.innerHTML = "<tr><td colspan='6'>No tasks assigned.</td></tr>";
                return;
            }

            tasks.forEach(task => {
                let row = document.createElement("tr");
                row.innerHTML = `
                    <td>${task.id}</td>
                    <td>${task.volunteer_name}</td>
                    <td>${task.task_name}</td>
                    <td>${task.location}</td>
                    <td>${task.priority}</td>
                    <td>${task.status}</td>
                `;
                taskList.appendChild(row);
            });

            console.log("✅ Tasks successfully displayed in Admin Panel.");
        })
        .catch(error => console.error("❌ Error loading tasks:", error));
}



// ✅ Assign Task (100% FIXED)
function assignTask() {
    const taskData = {
        volunteer_id: Number(document.getElementById("volunteer").value),
        task_name: document.getElementById("task_name").value.trim(),
        location: document.getElementById("location").value.trim(),
        priority: document.getElementById("priority").value
    };

    console.log("🔵 Sending Task Data (FORCED JSON):", JSON.stringify(taskData));

    fetch("/PetCareProject/php/assign_task.php", {
        method: "POST",
        headers: { 
            "Accept": "application/json",
            "Content-Type": "application/json"
        },
        body: JSON.stringify(taskData)  // ✅ THIS ENSURES JSON IS SENT
    })
    .then(response => response.json())
    .then(data => {
        console.log("🟢 Server Response:", data);
        if (data.success) {
            alert("✅ Task Assigned Successfully!");
            loadTasks();
        } else {
            alert("❌ Error: " + data.error);
        }
    })
    .catch(error => console.error("❌ Task Assignment Error:", error));
}
