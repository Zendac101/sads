


function showForm(formId) {
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");


    sessionStorage.setItem("form-state", formId)
}
window.addEventListener("DOMContentLoaded", () => {
    const savedFormState = sessionStorage.getItem("form-state");

    if (savedFormState) {
        // If a state was saved (like your register form id), open it!
        showForm(savedFormState);
    } else {
        // Optional default: If nothing is saved, default to your login form ID
        showForm("login_form");
    }


    if (window.location.search) {
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, cleanUrl);
    }

});
