

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getAuth, sendSignInLinkToEmail, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

import { firebaseConfig } from "../api/user_auth.js"

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const provider = new GoogleAuthProvider();



//VERIFY EMAIL
document.getElementById("but_verify").addEventListener("click", (e) => {
    e.preventDefault();


    const pendingData = {
        username: document.getElementById("username") ? document.getElementById("username").value : "",
        fname: document.getElementById("fname") ? document.getElementById("fname").value : "",
        lname: document.getElementById("lname") ? document.getElementById("lname").value : "",
        email: document.getElementById("signUp_email") ? document.getElementById("signUp_email").value : "",
        password: document.getElementById("signUp_password") ? document.getElementById("signUp_password").value : "",
        conPassword: document.getElementById("con_password") ? document.getElementById("con_password").value : ""
    };


    window.sessionStorage.setItem('pendingSignUpData', JSON.stringify(pendingData));




    const actionCodeSettings = {
        // URL you want to redirect back to. The domain (www.example.com) for this
        // URL must be in the authorized domains list in the Firebase Console.
        url: 'http://localhost:8080/aurae_website/SAD_WEB/index.php',
        // This must be true.
        handleCodeInApp: true,


        //linkDomain: 'custom-domain.com'
    };


    const email = pendingData.email;

    sendSignInLinkToEmail(auth, email, actionCodeSettings)
        .then(() => {

            alert("Verification email sent! Check your inbox.");
            // if they open the link on the same device.
            window.localStorage.setItem('emailForSignIn', email.value);

        })
        .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            console.log(errorMessage);
        });

})

//GOOGLE LOGIN POPUP
document.getElementById("google_btn").addEventListener("click", () => {

    signInWithPopup(auth, provider)
        .then((result) => {
            // This gives you a Google Access Token. You can use it to access the Google API.
            const credential = GoogleAuthProvider.credentialFromResult(result);
            const token = credential.accessToken;
            // The signed-in user info.
            const user = result.user;
            // IdP data available using getAdditionalUserInfo(result)
            // ...
        }).catch((error) => {
            // Handle Errors here.
            const errorCode = error.code;
            const errorMessage = error.message;
            // The email of the user's account used.
            const email = error.customData.email;
            // The AuthCredential type that was used.
            const credential = GoogleAuthProvider.credentialFromError(error);

        });

})


//RECOVER THE INPUTS
let verified_email = false;

window.addEventListener("DOMContentLoaded", () => {


    const savedInputs = JSON.parse(sessionStorage.getItem('pendingSignUpData'));
    if (savedInputs) {
        if (document.getElementById("username")) document.getElementById("username").value = savedInputs.username || "";
        if (document.getElementById("fname")) document.getElementById("fname").value = savedInputs.fname || "";
        if (document.getElementById("lname")) document.getElementById("lname").value = savedInputs.lname || "";
        if (document.getElementById("signUp_email")) document.getElementById("signUp_email").value = savedInputs.email || "";
        if (document.getElementById("signUp_password")) document.getElementById("signUp_password").value = savedInputs.password || "";
        if (document.getElementById("con_password")) document.getElementById("con_password").value = savedInputs.conPassword || "";

        verified_email = true;
    }


});

//submit the form

document.getElementById("submits_btn").addEventListener("click", (e) => {

    e.preventDefault();

    const pendingData = {
        username: document.getElementById("username") ? document.getElementById("username").value : "",
        fname: document.getElementById("fname") ? document.getElementById("fname").value : "",
        lname: document.getElementById("lname") ? document.getElementById("lname").value : "",
        email: document.getElementById("signUp_email") ? document.getElementById("signUp_email").value : "",
        password: document.getElementById("signUp_password") ? document.getElementById("signUp_password").value : "",
        conPassword: document.getElementById("con_password") ? document.getElementById("con_password").value : ""
    };


    window.sessionStorage.setItem('pendingSignUpData', JSON.stringify(pendingData));

    var sub_form = document.getElementById("signUp_form");



    sub_form.method = "POST";
    sub_form.submit();

})





