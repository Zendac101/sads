const password = document.getElementById('password');
const con_password = document.getElementById('con_password');
const enter = document.getElementById('submits_btn');
const form = document.querySelector('.card');


enter.addEventListener("click", function () {
    event.preventDefault();
    if (password.value == con_password.value) {
        form.method = "post";
        form.action = 'connection/user_reg.php';
        console.log("success");
        form.submit();



    }
    else {
        alert('failed');


        console.log("failed");
    }
});
