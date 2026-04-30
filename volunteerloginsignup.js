document.addEventListener("DOMContentLoaded", () => {
    // Toggle Forms
    const signUp = document.querySelector(".sign-up-form");
    const signIn = document.querySelector(".sign-in-form");
    const toggle = document.querySelectorAll(".toggle");
    const main = document.querySelector("main");

    toggle.forEach((btn) =>
        btn.addEventListener("click", () => {
            signUp.classList.toggle("active");
            signIn.classList.toggle("active");
            main.classList.toggle("sign-up-mode");
        })
    );

    // Form Field Effects
    const inputFields = document.querySelectorAll(".input-field");
    inputFields.forEach((input) => {
        input.addEventListener("focus", () => {
            input.classList.add("active");
        });
        input.addEventListener("blur", () => {
            if (!input.value) {
                input.classList.remove("active");
            }
        });
    });

    // Signup Form Submission
    document.getElementById("signup-form").addEventListener("submit", function(event) {
        event.preventDefault();  // ✅ Prevents form from refreshing
    
        console.log("🔵 Signup Form Submitted"); // ✅ Debugging log
    
        let formData = new FormData(this);
    
        fetch("php/volunteer_signup.php", {  
            method: "POST",  // ✅ Ensure it's a POST request
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("🟢 Server Response:", data);  // ✅ Debugging log
    
            let messageElement = document.getElementById("signup-message");
            messageElement.style.display = "block";
            messageElement.style.color = data.status === "success" ? "green" : "red";
            messageElement.textContent = data.message;
    
            if (data.status === "success") {
                document.getElementById("signup-form").reset();
            }
        })
        .catch(error => console.error("🔴 Fetch Error:", error));
    });
    

    // Login Form Submission
    document.getElementById("login-form").addEventListener("submit", function(event) {
        event.preventDefault();

        console.log("🔵 Login Form Submitted");

        let formData = new FormData(this);

        fetch("php/volunteer_login.php", {
            // ✅ Correct path
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("🟢 Server Response:", data);
            let messageElement = document.getElementById("login-message");
            messageElement.style.display = "block";
            messageElement.style.color = data.status === "success" ? "green" : "red";
            messageElement.textContent = data.message;

            if (data.status === "success") {
                setTimeout(() => window.location.href = "volunteer_dashboard.html", 1000);
            }
            
        })
        .catch(error => console.error("🔴 Fetch Error:", error));
    });
});
