function toggleSidebar() {
    var sidebar = document.querySelector('.sidebar');
    var menuBtn = document.querySelector('.menu-btn');
    var body = document.body;

    // Toggle the sidebar width and move the content
    if (sidebar.style.width === '220px') {
        sidebar.style.width = '0'; // Hide sidebar
        body.classList.remove('sidebar-open'); // Shift content back
    } else {
        sidebar.style.width = '220px'; // Show sidebar
        body.classList.add('sidebar-open'); // Shift content to the right
    }

    // Toggle menu button visibility
    menuBtn.classList.toggle('hidden');
}
