

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getAuth, sendSignInLinkToEmail, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-auth.js";

import { firebaseConfig } from "../api/user_auth.js"

const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const provider = new GoogleAuthProvider();



//VERIFY EMAIL
document.getElementById("but_verify").addEventListener("click", (e) => {
    e.preventDefault();


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










