function openModal() {
    document.getElementById("signupModal").style.display = "block";
}

function closeModal() {
    document.getElementById("signupModal").style.display = "none";
}

document.getElementById("volunteerForm").addEventListener("submit", function(event) {
    event.preventDefault();
    alert("✅ Signup Successful! We’ll get in touch soon.");
    closeModal();
});
