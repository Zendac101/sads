
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
import { getDatabase, ref, onValue } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-database.js";
import { firebaseConfig } from "../../api/firebase_api.js";


// Initialize Firebase

const app = initializeApp(firebaseConfig);


const database = getDatabase(app);


const humidRef = ref(database, "Sensor/humid");
const tempRef = ref(database, "Sensor/temp");


onValue(humidRef, (snapshot) => {
    const humid = snapshot.val();
    const elem = document.getElementById("humid_data");
    if (elem) elem.innerText = humid;
});

onValue(tempRef, (snapshot) => {
    const temp = snapshot.val();
    const elem = document.getElementById("temp_data");
    if (elem) elem.innerText = temp;
});
