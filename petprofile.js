document.addEventListener("DOMContentLoaded", async () => {
  const uploadButton = document.getElementById("upload-pet-images-btn");
  const modal = document.getElementById("imageUploadModal");
  const closeModal = document.querySelector(".modal-content .close");
  const uploadInput = document.getElementById("imageInput");
  const uploadBtn = document.getElementById("uploadBtn");
  const galleryContainer = document.querySelector(".gallery-container");
  const petNameElement = document.getElementById("pet-name");
  const petBreedElement = document.getElementById("pet-breed");
  const petAgeElement = document.getElementById("pet-age");

  // Fetch and display pet profile data
  async function fetchPetProfile() {
    try {
      const response = await fetch("fetch_pet_profile.php"); // Backend script
      const data = await response.json();

      if (data.error) {
        console.error(data.error);
        return;
      }

      // Update pet profile details
      petNameElement.textContent = data.pet_name || "Unknown";
      petBreedElement.textContent = data.pet_breed || "Unknown";
      petAgeElement.textContent = data.pet_age || "Unknown";

      // Load existing images
      if (data.images && Array.isArray(data.images)) {
        galleryContainer.innerHTML = ""; // Clear gallery before adding
        data.images.forEach((imageUrl) => {
          displayImage(imageUrl);
        });
      }
    } catch (error) {
      console.error("Error fetching pet profile:", error);
    }
  }

  // Call function to load pet data on page load
  await fetchPetProfile();

  // Show modal when upload button is clicked
  uploadButton.addEventListener("click", () => {
    modal.style.display = "flex";
  });

  // Close modal when close button or outside area is clicked
  closeModal.addEventListener("click", closeUploadModal);
  window.addEventListener("click", (e) => {
    if (e.target === modal) closeUploadModal();
  });

  // Close modal with ESC key
  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modal.style.display === "flex") {
      closeUploadModal();
    }
  });

  function closeUploadModal() {
    modal.style.display = "none";
    uploadInput.value = ""; // Reset input field
  }

  // Handle file upload and preview images
  uploadBtn.addEventListener("click", async () => {
    const files = uploadInput.files;
    if (files.length === 0) {
      alert("Please select at least one image.");
      return;
    }

    const formData = new FormData();
    Array.from(files).forEach((file) => {
      formData.append("images[]", file);
    });

    try {
      const response = await fetch("upload_pet_images.php", {
        method: "POST",
        body: formData,
      });

      const result = await response.json();
      if (result.success) {
        result.imageUrls.forEach((imageUrl) => {
          displayImage(imageUrl);
        });
      } else {
        alert("Image upload failed!");
      }
    } catch (error) {
      console.error("Error uploading images:", error);
    }

    closeUploadModal();
  });

  // Function to display images in gallery
  function displayImage(imageSrc) {
    const img = document.createElement("img");
    img.src = imageSrc;
    img.alt = "Uploaded Pet Image";
    img.className = "gallery-image";
    galleryContainer.appendChild(img);
  }
  document.addEventListener("DOMContentLoaded", function () {
    fetch("fetch_pet_profile.php")
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
            } else {
                document.getElementById("pet-name").textContent = data.pet_name;
                document.getElementById("pet-age").textContent = data.age;
                document.getElementById("pet-breed").textContent = data.breed;
            }
        })
        .catch(error => console.error("Error fetching pet profile:", error));
});

});
