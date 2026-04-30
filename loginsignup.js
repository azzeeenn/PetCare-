document.addEventListener("DOMContentLoaded", () => {
  const signUp = document.querySelector(".sign-up-form");
  const signIn = document.querySelector(".sign-in-form");
  const toggle = document.querySelectorAll(".toggle");
  const main = document.querySelector("main");

  toggle.forEach((btn) =>
    btn.addEventListener("click", () => {
      console.log("Toggling sign-up and sign-in forms.");
      signUp.classList.toggle("active");
      signIn.classList.toggle("active");
      main.classList.toggle("sign-up-mode");
    })
  );

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

  // Login Button Validation
  const signInBtn = document.querySelector(".sign-btn");
  const usernameField = document.querySelector("#login-username");
  const passwordField = document.querySelector("#login-password");

  signInBtn.addEventListener("click", (event) => {
    event.preventDefault();  // Prevent form submission initially
    const username = usernameField?.value.trim();
    const password = passwordField?.value.trim();
  
    console.log("Login clicked. Username:", username, "Password:", password);
  
    if (!username || !password) {
      alert("Please fill in both username and password fields.");
      return;
    }
  
    // Log username and password for debugging
    console.log("Entered username:", username);
    console.log("Entered password:", password);
  
    if (username && password) {
      // Submit the form after validation
      document.querySelector("form").submit();  // This will submit the form now
    }
  });
  
  // Sign-Up Button Validation
  const signUpBtn = document.querySelector(".sign-up-btn");
  const signUpFields = document.querySelectorAll(".sign-up-form .input-field");

  signUpBtn?.addEventListener("click", (event) => {
    event.preventDefault();
    console.log("Sign-Up clicked.");

    let allFieldsFilled = true;

    signUpFields.forEach((field) => {
      if (!field.value.trim()) {
        allFieldsFilled = false;
      }
    });

    if (!allFieldsFilled) {
      alert("Please fill in all required fields for sign-up.");
      return;
    }

    alert("Sign-Up successful! Redirecting to login...");
    toggle.forEach((btn) => btn.click()); // Switch to sign-in form
  });

  // Image Carousel Functionality
  const images = document.querySelectorAll(".image");
  const bullets = document.querySelectorAll(".bullets span");
  let currentImageIndex = 0;

  // Function to show the current image
  function showImage(index) {
    images.forEach((img, i) => {
      img.classList.toggle("show", i === index);
      bullets[i].classList.toggle("active", i === index);
    });
  }

  // Function to move to the next image
  function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    showImage(currentImageIndex);
  }

  // Automatically cycle through images
  setInterval(nextImage, 3000);

  // Bullet navigation
  bullets.forEach((bullet, index) => {
    bullet.addEventListener("click", () => {
      currentImageIndex = index;
      showImage(currentImageIndex);
    });
  });
});
