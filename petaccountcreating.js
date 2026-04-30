document.addEventListener("DOMContentLoaded", function () {
    let currentStep = 1;
    const steps = document.querySelectorAll(".form-step");
    const totalSteps = steps.length;
    const form = document.getElementById("petForm");

    function showStep(step) {
        steps.forEach((formStep, index) => {
            formStep.style.display = index + 1 === step ? "block" : "none";
        });
    }

    document.querySelectorAll(".next-btn").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    document.querySelectorAll(".back-btn").forEach((button) => {
        button.addEventListener("click", function (e) {
            e.preventDefault();
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    // Form Submission Logic (AJAX)
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("submit_pet_form.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Form submitted successfully!");
                form.reset();
                showStep(1); // Reset to first step
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Something went wrong. Please try again.");
        });
    });

    showStep(currentStep);
});
