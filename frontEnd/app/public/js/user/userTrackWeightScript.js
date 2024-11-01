let weightDataset = JSON.parse(document.getElementById('phpWeightDataset').value);
let currentPaginationDate = JSON.parse(document.getElementById('currentPaginationDate').value);
const GRAMTOKILOGRAMCONVERSIONRATE = 1000;
const GRAMTOPOUNDCONVERSIONRATE = 453.6;

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
function redirectTrackWeightPage() {
    let dateInput = document.getElementById("dateOfWeight");
    location.href = "track-weight.php?date=" + dateInput.value;
}

/** Redirects the user to the same website with GET request to the previous date. */
function previousDate() {
    let dateInput = document.getElementById("dateOfWeight");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() - 1);
    location.href = "track-weight.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Redirects the user to the same website with GET request to the next date. */
function nextDate() {
    let dateInput = document.getElementById("dateOfWeight");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() + 1);
    location.href = "track-weight.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
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
    if (unitDropDownBoxID === "weightUnitInUserTrackWeightView") {
        document.getElementById('weightUnitInWeightDataModalInUserTrackWeightView').value = document.getElementById("weightUnitInUserTrackWeightView").value;
        
    } else if (unitDropDownBoxID === "weightUnitInWeightDataModalInUserTrackWeightView") {
        document.getElementById('weightUnitInUserTrackWeightView').value = document.getElementById("weightUnitInWeightDataModalInUserTrackWeightView").value;
    }
    let unitSelected = document.getElementById('weightUnitInUserTrackWeightView').value;

    // The loop gets the key, and the key of the dataset is the ID.
    for (let weightID in weightDataset) {
        if (weightDataset.hasOwnProperty(weightID)) {
            let weightDataRow = document.getElementById(weightID + "Text");
            weightDataRow.innerText = "You weigh " + convertValueOfGramToWeightUnit(Number(weightDataset[weightID]["weightInGram"]), unitSelected) +
            unitSelected + " at " + weightDataset[weightID]["recordedOnTime"];
        }
    }
}

/** This function is used to send to track-weight.php?date=...,
 * to persist the unit selected by the user.
 */
function createSessionForWeightUnitSelected() {
    
    
    let unitSelected = document.getElementById("weightUnitInUserTrackWeightView").value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("weightUnitInUserTrackWeightView=" + unitSelected);
}

/** Updates weight messages. */
function updateWeightMessages() {
    
    // Formatted the date to be used for user readability.
    let currentDate = new Date();
    let currentDateString = currentDate.getDate() + "-" + (currentDate.getMonth() +  1) + "-" + currentDate.getFullYear();
    let paginationDate = new Date(currentPaginationDate);
    let paginationDateString = paginationDate.getDate() + "-" + (paginationDate.getMonth() +  1) + "-" + paginationDate.getFullYear();
    let weightStatusMessage = document.getElementById('weightStatusMessage');
    let weightEncouragementMessage = document.getElementById('weightEncouragementMessage');


    if (!isDatasetEmpty(weightDataset)) {

        

        // Start of time.
        let weightTime = "00:00";
        
        let weightID = -1;

        // weightDataID is weightID, just a placeholder name.
        // Trying to get the most latest weightID.
        for (let weightDataID in weightDataset) {
            if (weightDataset.hasOwnProperty(weightDataID)) {
                if (weightDataset[weightDataID]["recordedOnTime"] > weightTime) {
                    weightTime = weightDataset[weightDataID]["recordedOnTime"];
                    weightID = weightDataID;
                }
            }
        }

        let unitSelected = document.getElementById('weightUnitInUserTrackWeightView').value;

        let weightWithUnitText = convertValueOfGramToWeightUnit(Number(weightDataset[weightID]["weightInGram"]), unitSelected);
        weightWithUnitText += unitSelected;

        if (paginationDateString === currentDateString) {
            weightStatusMessage.innerText = "Your latest weight is " + weightWithUnitText + " today!";
            weightEncouragementMessage.innerText = "Keep up the good work!";
        } else {
            weightStatusMessage.innerText = "Your latest weight on " + paginationDateString + " is " + weightWithUnitText;
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

    weightUnitSelected = document.getElementById("weightUnitInUserTrackWeightView").value;

    submitWeightDataButton.value="Save"
    modalTitle.innerText = 'Edit Weight Data';
    weightIDInput.value = weightID;

    weightInput.value = convertValueOfGramToWeightUnit(Number(weightDataset[weightID]["weightInGram"]), weightUnitSelected);

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


convertWeightOfAllWeightDataRow("weightUnitInUserTrackWeightView");
updateWeightMessages();