const acc_overlay = document.getElementById("account_overlay");


document.getElementById("edit_account").addEventListener('click', function () {

    acc_overlay.showModal();

})
document.getElementById("close_but").addEventListener('click', function () {

    acc_overlay.close();

})