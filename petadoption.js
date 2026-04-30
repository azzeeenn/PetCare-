function openSidebar() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("logo").style.transform = "translateX(250px)"; // Move the logo to the right
}

function closeSidebar() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("logo").style.transform = "translateX(0)"; // Reset the logo to center
}

