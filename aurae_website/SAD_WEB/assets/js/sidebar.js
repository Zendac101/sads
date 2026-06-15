document.addEventListener("DOMContentLoaded", function () {
    // Get the current file name from the URL (e.g., "analysis.php")
    const currentPath = window.location.pathname.split("/").pop();

    // Loop through all links in the sidebar menu
    const menuLinks = document.querySelectorAll(".sidebar .menu a");

    menuLinks.forEach(link => {
        // Check if the link's href matches the current page
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");
            // Optional: If you want to style the parent <li> instead
            link.parentElement.classList.add("active-item");
        }
    });
});