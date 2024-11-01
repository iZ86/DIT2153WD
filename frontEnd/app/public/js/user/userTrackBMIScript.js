let bmiDataset = JSON.parse(document.getElementById('phpBMIDataset').value);
let currentPaginationDate = JSON.parse(document.getElementById('currentPaginationDate').value);
const CENTIMETERTOMETERCONVERSIONRATE = 100;
const CENTIMETERTOFOOTCONVERSIONRATE = 30.48;
const GRAMTOKILOGRAMCONVERSIONRATE = 1000;
const GRAMTOPOUNDCONVERSIONRATE = 453.6;



/** Converts any value of centimeter to any value of height unit.
 * Returns -1, if the unit is not supported.
 */
function convertValueOfCentimeterToHeightUnit(value, heightUnit) {
    if (heightUnit === "cm") {
        return value;
    } else if (heightUnit === "m") {
        return Math.floor((value / CENTIMETERTOMETERCONVERSIONRATE) * 10000) / 10000;
    } else if (heightUnit === "ft") {
        return Math.floor((value / CENTIMETERTOFOOTCONVERSIONRATE) * 10000) / 10000;
    }
    return -1;
}

/** Converts any value of gram to any value of weight unit.
 * Returns -1, if the unit is not supported.
 */
function convertValueOfGramToWeightUnit(value, weightUnit) {
    if (weightUnit === "g") {
        return value;
    } else if (weightUnit === "Kg") {
        return Math.floor((value / GRAMTOKILOGRAMCONVERSIONRATE) * 10000) / 10000;
    } else if (weightUnit === "lb") {
        return Math.floor((value / GRAMTOPOUNDCONVERSIONRATE) * 10000) / 10000;
    }
    return -1;
}

/** Redirects the user based on the date inputted in the calendar. */
function redirectTrackBMIPage() {
    let dateInput = document.getElementById("dateOfBMI");
    location.href = "track-bmi.php?date=" + dateInput.value;
}

/** Redirects the user to the same website with GET request to the previous date. */
function previousDate() {
    let dateInput = document.getElementById("dateOfBMI");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() - 1);
    location.href = "track-bmi.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Redirects the user to the same website with GET request to the next date. */
function nextDate() {
    let dateInput = document.getElementById("dateOfBMI");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() + 1);
    location.href = "track-bmi.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Checks if the datasets are empty. */
function isDatasetEmpty(dataset) {
    for (let data in dataset) {
        if (dataset.hasOwnProperty(data)) {
            return false;
        }
        return true;
    }
    return true;
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
    for (let bmiID in bmiDataset) {
        if (bmiDataset.hasOwnProperty(bmiID)) {
            let bmiDataRowText =  document.getElementById(bmiID+ "Text");
            bmiDataRowText.innerText = "Your calculated BMI is " + 
            calculateBMI(convertValueOfGramToWeightUnit(Number(bmiDataset[bmiID]["weightInGram"]), "Kg"),
            convertValueOfCentimeterToHeightUnit(Number(bmiDataset[bmiID]["heightInCentimeter"]), "m")) +
            " at " + bmiDataset[bmiID]["recordedOnTime"];
        }
    }
}

/** This function is used to send to track-bmi.php?date=...,
 * to persist the height unit selected by the user.
 */
function createSessionForHeightUnitSelected() {
    let unitSelected = document.getElementById('heightUnitInBMIDataModalInUserTrackBMIView').value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("heightUnitInBMIDataModalInUserTrackBMIView=" + unitSelected);
}

/** This function is used to send to track-bmi.php?date=...,
 * to persist the weight unit selected by the user.
 */
function createSessionForWeightUnitSelected() {
    let unitSelected = document.getElementById('weightUnitInBMIDataModalInUserTrackBMIView').value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("weightUnitInBMIDataModalInUserTrackBMIView=" + unitSelected);
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
    let bmiStatusMessage = document.getElementById('bmiStatusMessage');
    let bmiEncouragementMessage = document.getElementById('bmiEncouragementMessage');




    if (!isDatasetEmpty(bmiDataset)) {

        

        let bmiID = -1;

        // Start of time.
        let bmiTime = "00:00:00";

        // bmiDataID is bmiID, just a placeholder name.
        // Trying to get the most latest bmiID.
        for (let bmiDataID in bmiDataset) {
            if (bmiDataset.hasOwnProperty(bmiDataID)) {
                if (bmiDataset[bmiDataID]["recordedOnTime"] > bmiTime) {
                    bmiTime = bmiDataset[bmiDataID]["recordedOnTime"];
                    bmiID = bmiDataID;
                }
            }
        }

        let bmiValue = calculateBMI(convertValueOfGramToWeightUnit(Number(bmiDataset[bmiID]["weightInGram"]), "Kg"),
        convertValueOfCentimeterToHeightUnit(Number(bmiDataset[bmiID]["heightInCentimeter"]), "m"));


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
    let heightUnitSelected = document.getElementById("heightUnitInBMIDataModalInUserTrackBMIView").value;
    let weightInput = document.getElementById("weight");
    let weightUnitSelected = document.getElementById("weightUnitInBMIDataModalInUserTrackBMIView").value;
    let timeInput = document.getElementById('time');


    
    modalTitle.innerText = 'Edit BMI Data';
    deleteBMIDataButton.classList.remove('hidden');
    submitBMIDataButton.value="Save"


    bmiIDInput.value = bmiID;
    ageInput.value = bmiDataset[bmiID]["age"];

    let gender = bmiDataset[bmiID]["gender"];
    if (gender === "male") {
        maleRadioInput.checked = true;
    } else if (gender === "female") {
        femaleRadioInput.checked = true;
    }

    heightInput.value = convertValueOfCentimeterToHeightUnit(Number(bmiDataset[bmiID]["heightInCentimeter"]), heightUnitSelected)
    weightInput.value = convertValueOfGramToWeightUnit(Number(bmiDataset[bmiID]["weightInGram"]), weightUnitSelected);
    
    timeInput.value = bmiDataset[bmiID]["recordedOnTime"];

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