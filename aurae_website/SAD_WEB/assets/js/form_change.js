


function showForm(formId) {
    document.querySelectorAll(".form-box").forEach(form => form.classList.toggle("active"));

}
window.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const hasError = urlParams.has("reg_error") || urlParams.has("log_error") || urlParams.has("state");

    if (!hasError) {
        const savedFormState = sessionStorage.getItem("form-state");
        if (savedFormState) {
            showForm(savedFormState);
        }
    }


    if (window.location.search) {
        const cleanUrl = window.location.origin + window.location.pathname;
        window.history.replaceState({}, document.title, cleanUrl);
    }

});
