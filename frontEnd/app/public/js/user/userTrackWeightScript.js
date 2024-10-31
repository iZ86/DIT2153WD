let weightDataset = JSON.parse(document.getElementById('phpWeightDataset').value);
let currentPaginationDate = JSON.parse(document.getElementById('currentPaginationDate').value);
const KILOGRAMSTOGRAMSCONVERSIONRATE = 1000;
const KILOGRAMSTOPOUNDSCONVERSIONRATE = 2.20462;

/** Redirects the user based on the date inputted in the calendar. */
function redirectTrackWeightPage() {
    let dateInput = document.getElementById("dateOfWeight");
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-weight.php?date=" + dateInput.value;
}

/** Redirects the user to the same website with GET request to the previous date. */
function previousDate() {
    let dateInput = document.getElementById("dateOfWeight");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() - 1);
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-weight.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Redirects the user to the same website with GET request to the next date. */
function nextDate() {
    let dateInput = document.getElementById("dateOfWeight");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() + 1);
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-weight.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Opens weightDataModal to add data. */
function openAddWeightDataModal() {
    const modal = document.getElementById('weightDataModal');
    const overlay = document.getElementById('modalOverlay');
    let submitWeightDataButton = document.getElementById('submitWeightDataButton');
    let modalTitle = document.getElementById('modalTitle');
    submitWeightDataButton.value="Add";
    modalTitle.innerText = 'Add Weight Data';

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

/** Closes weightDataModal. */
function closeWeightDataModal() {
    const modal = document.getElementById('weightDataModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    
    let deleteWeightDataButton = document.getElementById('deleteWeightDataButton');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        deleteWeightDataButton.classList.add('hidden');
        clearModalFields();
    }, 300);
}

/** Clear modal fields. */
function clearModalFields() {
    document.getElementById('weightID').value = "";
    document.getElementById("weight").value="";
    document.getElementById('time').value="";
}

/** Converts the amount for every weight data rows. */
function convertWeightOfAllWeightDataRow(unitDropDownBoxID) {
    if (unitDropDownBoxID === "weightUnit") {
        document.getElementById('unit').value = document.getElementById("weightUnit").value;
        
    } else if (unitDropDownBoxID === "unit") {
        document.getElementById('weightUnit').value = document.getElementById("unit").value;
    }
    let unitSelected = document.getElementById('weightUnit').value;


    if (unitSelected === "Kg") {
        Object.entries(weightDataset).map(entry => {
            let weightData = entry[1];
            let weight = new Number(weightData["weight"]);
            let weightDataRow = document.getElementById(weightData["weightID"] + "Text");
            weightDataRow.innerText = "You weigh " + weight + unitSelected + " at " + weightData["recordedOnTime"];
        });
    
    } else if (unitSelected === "g") {
        Object.entries(weightDataset).map(entry => {
            let weightData = entry[1];
            let weight = convertKilogramsToGrams(Number(weightData["weight"]));
            let weightDataRow = document.getElementById(weightData["weightID"] + "Text");
            weightDataRow.innerText = "You weigh " + weight + unitSelected + " at " + weightData["recordedOnTime"];
        });
    } else if (unitSelected === "lb") {
        Object.entries(weightDataset).map(entry => {
            let weightData = entry[1];
            let weight = convertKilogramsToPounds(new Number(weightData["weight"]));
            let weightDataRow = document.getElementById(weightData["weightID"] + "Text");
            weightDataRow.innerText = "You weigh " + weight + unitSelected + " at " + weightData["recordedOnTime"];
        });
    }
}

/** This function is used to send to track-weight.php?date=...,
 * to persist the unit selected by the user.
 */
function createSessionForUnitSelected(unitDropDownBoxID) {
    let unitSelected = document.getElementById(unitDropDownBoxID).value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("unit=" + unitSelected);
}

/** Converts kilograms to grams */
function convertKilogramsToGrams(kilograms) {
    return Math.floor(kilograms * KILOGRAMSTOGRAMSCONVERSIONRATE * 100) / 100;
}

/** Converts kilograms to pounds. */
function convertKilogramsToPounds(kilograms) {
    return Math.floor(kilograms * KILOGRAMSTOPOUNDSCONVERSIONRATE * 100) / 100;
}

/** Updates weight messages. */
function updateWeightMessages() {
    
    // Formatted the date to be used for user readability.
    let currentDate = new Date();
    let currentDateString = currentDate.getDate() + "-" + (currentDate.getMonth() +  1) + "-" + currentDate.getFullYear();
    let paginationDate = new Date(currentPaginationDate);
    let paginationDateString = paginationDate.getDate() + "-" + (paginationDate.getMonth() +  1) + "-" + paginationDate.getFullYear();

    let latestWeight = -1;

    // Start of time.
    let weightTime = "00:00";

    Object.entries(weightDataset).map(entry => {
        let weightData = entry[1];
        if (weightData["recordedOnTime"] > weightTime) {
            latestWeight = weightData["weight"];
            weightTime = weightData["recordedOnTime"];
        }
    });

    let weightStatusMessage = document.getElementById('weightStatusMessage');
    let weightEncouragementMessage = document.getElementById('weightEncouragementMessage');

    let weightInUnitText;
    let unitSelected = document.getElementById('weightUnit').value;
    if (unitSelected === "Kg") {
        weightInUnitText = latestWeight + "Kg";
    } else if (unitSelected === "g") {
        weightInUnitText = convertKilogramsToGrams(latestWeight) + "g";
    } else if (unitSelected === "lb") {
        weightInUnitText = convertKilogramsToPounds(latestWeight) + "lb";
    } else {
        weightInUnitText = "Error"
    }

    if (latestWeight > 0) {
        if (paginationDateString === currentDateString) {
            weightStatusMessage.innerText = "Your latest weight is " + weightInUnitText + " today!";
            weightEncouragementMessage.innerText = "Keep up the good work!";
        } else {
            weightStatusMessage.innerText = "Your latest weight on " + paginationDateString + " is " + weightInUnitText;
            weightEncouragementMessage.innerText = "";
        }
    } else {
        if (paginationDateString === currentDateString) {
            weightStatusMessage.innerText = "You have not yet weigh yourself!";
            weightEncouragementMessage.innerHTML = "Add a weight!";
        } else {
            weightStatusMessage.innerText = "You did not weight yourself on " + paginationDateString;
            weightEncouragementMessage.innerHTML = "";
        }
    }

   
}

/** Opens the weightDataModal to edit data. */
function openEditWeightDataModal(weightID) {
    let modal = document.getElementById('weightDataModal');
    let overlay = document.getElementById('modalOverlay');
    let deleteWeightDataButton = document.getElementById('deleteWeightDataButton');
    let submitWeightDataButton = document.getElementById('submitWeightDataButton');
    let modalTitle = document.getElementById('modalTitle');
    let weightInput = document.getElementById("weight");
    let timeInput = document.getElementById('time');
    let weightIDInput = document.getElementById("weightID");

    unitSelected = document.getElementById("weightUnit").value;

    submitWeightDataButton.value="Save"
    modalTitle.innerText = 'Edit Weight Data';
    weightIDInput.value = weightID;


    if (unitSelected === "Kg") {
        weightInput.value = weightDataset[weightID]["weight"];
    } else if (unitSelected === "g") {
        weightInput.value = convertKilogramsToGrams(new Number(weightDataset[weightID]['weight']));
    } else if (unitSelected === "lb") {
        weightInput.value = convertKilogramsToPounds(new Number(weightDataset[weightID]['weight']));
    }
    timeInput.value = weightDataset[weightID]["recordedOnTime"];

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    
    
    deleteWeightDataButton.classList.remove('hidden');


    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

}
    

/** Opens weightDataModal to add data. */
function openDeleteConfirmationModal() {
    let confirmationModal = document.getElementById('confirmationModal');

    confirmationModal.classList.remove('hidden');
    setTimeout(() => {
        confirmationModal.classList.add('show');
    }, 10);
}

/** Closes weightDataModal. */
function closeConfirmationModal() {
    let confirmationModal = document.getElementById('confirmationModal');

    

    confirmationModal.classList.remove('show');


    setTimeout(() => {
        confirmationModal.classList.add('hidden');
    }, 300);
}




convertWeightOfAllWeightDataRow("weightUnit");
updateWeightMessages();