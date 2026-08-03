




document.addEventListener("DOMContentLoaded", function () {
    const currentPath = window.location.pathname.split("/").pop();

    const menuLinks = document.querySelectorAll(".sidebar .menu a");

    menuLinks.forEach(link => {
        // Check if the link's href matches the current page
        if (link.getAttribute("href") === currentPath) {
            link.classList.add("active");

        }
    });



});

