const password = document.getElementById('password');
const con_password = document.getElementById('con_password');
const form = document.querySelector('.card');

form.addEventListener("submit", function (event) {

    if (password.value !== con_password.value) {
        event.preventDefault();

        //alert("Passwords do not match!");
        password.style.backgroundColor = "#e17e7e";
        con_password.style.backgroundColor = "#e17e7e";
        console.log("Registration failed");
    } else {
        console.log("Sucess");
    }
});