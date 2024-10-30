let bmiDataArray = JSON.parse(document.getElementById('phpArrayOfBMIData').value);
let currentPaginationDate = JSON.parse(document.getElementById('currentPaginationDate').value);
const KILOGRAMSTOGRAMSCONVERSIONRATE = 1000;
const KILOGRAMSTOPOUNDSCONVERSIONRATE = 2.20462;
const METERSTOCENTIMETERSCONVERSATIONRATE = 100;
const METERSTOFOOTCONVERSIONRATE = 3.28084;

/** Redirects the user based on the date inputted in the calendar. */
function redirectTrackBMIPage() {
    let dateInput = document.getElementById("dateOfBMI");
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-bmi.php?date=" + dateInput.value;
}

/** Redirects the user to the same website with GET request to the previous date. */
function previousDate() {
    let dateInput = document.getElementById("dateOfBMI");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() - 1);
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-bmi.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Redirects the user to the same website with GET request to the next date. */
function nextDate() {
    let dateInput = document.getElementById("dateOfBMI");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() + 1);
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-bmi.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Opens bmiDataModal to add data. */
function openAddBMIDataModal() {
    const modal = document.getElementById('bmiDataModal');
    const overlay = document.getElementById('modalOverlay');
    let submitBMIDataButton = document.getElementById('submitBMIDataButton');
    let modalTitle = document.getElementById('modalTitle');
    submitBMIDataButton.value="Add";
    modalTitle.innerText = 'Add BMI Data';

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

/** Closes bmiDataModal. */
function closeBMIDataModal() {
    const modal = document.getElementById('bmiDataModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    
    let deleteBMIDataButton = document.getElementById('deleteBMIDataButton');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        deleteBMIDataButton.classList.add('hidden');
        clearModalFields();
    }, 300);
}

/** Clear modal fields. */
function clearModalFields() {
    document.getElementById('bmiID').value = "";
    document.getElementById("age").value="";
    document.getElementById("maleRadio").checked = false;
    document.getElementById("femaleRadio").checked = false;
    document.getElementById("height").value = "";
    document.getElementById("weight").value = "";
    document.getElementById("time").value="";
}

/** Display all the necessary data. */
function displayDataOfAllBMIDataRow() {
    Object.entries(bmiDataArray).map(entry => {
        let bmiData = entry[1];
        let bmiDataRowText =  document.getElementById(bmiData["bmiID"] + "Text");
        bmiDataRowText.innerText = "Your calculated BMI is " + calculateBMI(new Number(bmiData["weight"]), new Number(bmiData["height"])) + " at " + bmiData["recordedOnTime"];
    });
}

/** This function is used to send to track-bmi.php?date=...,
 * to persist the height unit selected by the user.
 */
function createSessionForHeightUnitSelected(unitDropDownBoxID) {
    let unitSelected = document.getElementById(unitDropDownBoxID).value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("bmiHeightUnit=" + unitSelected);
}

/** This function is used to send to track-bmi.php?date=...,
 * to persist the weight unit selected by the user.
 */
function createSessionForweightUnitSelected(unitDropDownBoxID) {
    let unitSelected = document.getElementById(unitDropDownBoxID).value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("bmiWeightUnit=" + unitSelected);
}

/** Converts kilograms to grams */
function convertKilogramsToGrams(kilograms) {
    return Math.floor(kilograms * KILOGRAMSTOGRAMSCONVERSIONRATE * 100) / 100;
}

/** Converts kilograms to pounds. */
function convertKilogramsToPounds(kilograms) {
    return Math.floor(kilograms * KILOGRAMSTOPOUNDSCONVERSIONRATE * 100) / 100;
}

/** Converts meters to centimeters. */
function convertMetersToCentimeters(meters) {
    return Math.floor(meters * METERSTOCENTIMETERSCONVERSATIONRATE * 100) / 100;
}

/** Converts meters to foot. */
function convertMetersToFoot(meters) {
    return Math.floor(meters * METERSTOFOOTCONVERSIONRATE * 100) / 100;
}

/** Calculate bmi and returns it. */
function calculateBMI(weightInKg, heightInM) {
    let bmi = ((weightInKg / (Math.pow(heightInM, 2))) * 10);
    bmi = bmi % 10 > 4 ? Math.ceil(bmi) : Math.floor(bmi);
    return bmi / 10;
}

/** Updates bmi messages. */
function updateBMIMessages() {
    
    // Formatted the date to be used for user readability.
    let currentDate = new Date();
    let currentDateString = currentDate.getDate() + "-" + (currentDate.getMonth() +  1) + "-" + currentDate.getFullYear();
    let paginationDate = new Date(currentPaginationDate);
    let paginationDateString = paginationDate.getDate() + "-" + (paginationDate.getMonth() +  1) + "-" + paginationDate.getFullYear();


    let bodyHeight = -1;
    let bodyWeight = -1;


    // Start of time.
    let bmiTime = "00:00:00";

    Object.entries(bmiDataArray).map(entry => {
        let bmiData = entry[1];
        if (bmiData["recordedOnTime"] > bmiTime) {
            bodyHeight = bmiData["height"];
            bodyWeight = bmiData["weight"];
            bmiTime = bmiData["recordedOnTime"];
        }
    })

    let bmiValue = calculateBMI(new Number(bodyWeight), new Number(bodyHeight));
    let bmiStatusMessage = document.getElementById('bmiStatusMessage');
    let bmiEncouragementMessage = document.getElementById('bmiEncouragementMessage');


    if (bodyHeight > 0 && bodyWeight > 0) {
        if (paginationDateString === currentDateString) {
            bmiStatusMessage.innerText = "Your latest BMI calculated today is " + bmiValue + "!";
            bmiEncouragementMessage.innerText = "Keep up the good work!";
        } else {
            bmiStatusMessage.innerText = "Your latest BMI calculated on " + paginationDateString + " is " + bmiValue + "!";
            bmiEncouragementMessage.innerText = "";
        }
    } else {
        if (paginationDateString === currentDateString) {
            bmiStatusMessage.innerText = "You did not track your BMI today!";
            bmiEncouragementMessage.innerHTML = "Calculate and track now!";
        } else {
            bmiStatusMessage.innerText = "You did not track your BMI on " + paginationDateString;
            bmiEncouragementMessage.innerHTML = "";
        }
    }
}

/** Opens the bmiDataModal to edit data. */
function openEditBMIDataModal(bmiID) {
    let modal = document.getElementById('bmiDataModal');
    let overlay = document.getElementById('modalOverlay');
    let modalTitle = document.getElementById('modalTitle');
    let deleteBMIDataButton = document.getElementById('deleteBMIDataButton');
    let submitBMIDataButton = document.getElementById('submitBMIDataButton');
    

    let bmiIDInput = document.getElementById('bmiID');
    let ageInput = document.getElementById("age");
    let maleRadioInput = document.getElementById("maleRadio");
    let femaleRadioInput = document.getElementById("femaleRadio");
    let heightInput = document.getElementById("height");
    let heightUnitInput = document.getElementById("heightUnit").value;
    let weightInput = document.getElementById("weight");
    let weightUnitInput = document.getElementById("weightUnit").value;
    let timeInput = document.getElementById('time');


    
    modalTitle.innerText = 'Edit BMI Data';
    deleteBMIDataButton.classList.remove('hidden');
    submitBMIDataButton.value="Save"


    bmiIDInput.value = bmiID;
    ageInput.value = bmiDataArray[bmiID]["age"];

    let gender = bmiDataArray[bmiID]["gender"];
    if (gender === "male") {
        maleRadioInput.checked = true;
    } else if (gender === "female") {
        femaleRadioInput.checked = true;
    }

    if (heightUnitInput === "m") {
        heightInput.value = bmiDataArray[bmiID]["height"];
    } else if (heightUnitInput === "cm") {
        heightInput.value = convertMetersToCentimeter(bmiDataArray[bmiID]["height"]);
    } else if (heightUnitInput === "ft") {
        heightInput.value = convertMetersToFoot(bmiDataArray[bmiID]["height"]);
    }
    

    if (weightUnitInput === "Kg") {
        weightInput.value = bmiDataArray[bmiID]["weight"];
    } else if (weightUnitInput === "g") {
        weightInput.value = convertKilogramsToGrams(bmiDataArray[bmiID]["weight"]);
    } else if (weightUnitInput === "lb") {
        weightInput.value = convertKilogramsToPounds(bmiDataArray[bmiID]["weight"]);
    }
    
    timeInput.value = bmiDataArray[bmiID]["recordedOnTime"];

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

}
    

/** Opens deleteConfirmationModal. */
function openDeleteConfirmationModal() {
    let confirmationModal = document.getElementById('confirmationModal');

    confirmationModal.classList.remove('hidden');
    setTimeout(() => {
        confirmationModal.classList.add('show');
    }, 10);
}

/** Closes deleteConfirmationModal. */
function closeConfirmationModal() {
    let confirmationModal = document.getElementById('confirmationModal');

    confirmationModal.classList.remove('show');


    setTimeout(() => {
        confirmationModal.classList.add('hidden');
    }, 300);
}


displayDataOfAllBMIDataRow();
updateBMIMessages();