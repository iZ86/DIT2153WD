let waterConsumptionDataset = JSON.parse(document.getElementById('phpWaterConsumptionDataset').value);
let currentPaginationDate = JSON.parse(document.getElementById('currentPaginationDate').value);
const MILLILITERTOLITERCONVERSIONRATE = 1000;
const MILLILITERTOOUNCECONVERSIONRATE = 29.574;

/** Converts any value of milliliter to any value of volume unit.
 * Returns -1, if the unit is not supported.
 */
function convertValueOfMilliliterToValueUnit(value, volumeUnit) {
    if (volumeUnit === "mL") {
        return value;
    } else if (volumeUnit === "L") {
        return Math.floor((value / MILLILITERTOLITERCONVERSIONRATE) * 10000) / 10000;
    } else if (volumeUnit === "oz") {
        return Math.floor((value / MILLILITERTOOUNCECONVERSIONRATE) * 10000) / 10000;
    }
    return -1;
}


/** Redirects the user based on the date inputted in the calendar. */
function redirectTrackWaterConsumptionPage() {
    let dateInput = document.getElementById("dateOfWaterConsumption");
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=" + dateInput.value;
}

/** Redirects the user to the same website with GET request to the previous date. */
function previousDate() {
    let dateInput = document.getElementById("dateOfWaterConsumption");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() - 1);
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Redirects the user to the same website with GET request to the next date. */
function nextDate() {
    let dateInput = document.getElementById("dateOfWaterConsumption");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() + 1);
    location.href = "http://localhost/DIT2153WD/frontEnd/app/controllers/user/track-water-consumption.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
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

/** Opens waterConsumptionDataModal to add data. */
function openAddWaterConsumptionDataModal() {
    const modal = document.getElementById('waterConsumptionDataModal');
    const overlay = document.getElementById('modalOverlay');
    let submitWaterConsumptionDataButton = document.getElementById('submitWaterConsumptionDataButton');
    let modalTitle = document.getElementById('modalTitle');
    submitWaterConsumptionDataButton.value="Add";
    modalTitle.innerText = 'Add Water Consumption Data';

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

/** Closes waterConsumptionDataModal. */
function closeWaterConsumptionDataModal() {
    const modal = document.getElementById('waterConsumptionDataModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    
    let deleteWaterConsumptionDataButton = document.getElementById('deleteWaterConsumptionDataButton');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        deleteWaterConsumptionDataButton.classList.add('hidden');
        clearModalFields();
    }, 300);
}

/** Clear modal fields. */
function clearModalFields() {
    document.getElementById('waterConsumptionID').value = "";
    document.getElementById("amountDrank").value="";
    document.getElementById('time').value="";
}

/** Converts the amount for every water consumption data rows. */
function convertAmountDrankOfAllWaterConsumptionDataRow(unitDropDownBoxID) {
    if (unitDropDownBoxID === "volumeUnitInUserTrackWaterConsumptionView") {
        document.getElementById('volumeUnitInWaterConsumptionModalInUserTrackWaterConsumptionView').value = document.getElementById("volumeUnitInUserTrackWaterConsumptionView").value;
        
    } else if (unitDropDownBoxID === "volumeUnitInWaterConsumptionModalInUserTrackWaterConsumptionView") {
        document.getElementById('volumeUnitInUserTrackWaterConsumptionView').value = document.getElementById("volumeUnitInWaterConsumptionModalInUserTrackWaterConsumptionView").value;
    }
    let unitSelected = document.getElementById('volumeUnitInUserTrackWaterConsumptionView').value;

    // The loop gets the key, and the key of the dataset is the ID.
    for (let waterConsumptionID in waterConsumptionDataset) {
        if (waterConsumptionDataset.hasOwnProperty(waterConsumptionID)) {
            let waterConsumptionDataRow = document.getElementById(waterConsumptionID + "Text");
            let amountDrank = convertValueOfMilliliterToValueUnit(Number(waterConsumptionDataset[waterConsumptionID]["amountDrankInMilliliter"]), unitSelected);
            waterConsumptionDataRow.innerText = "You have drank " + amountDrank + unitSelected + " at " + waterConsumptionDataset[waterConsumptionID]["recordedOnTime"];
        }
    }
}

/** This function is used to send to track-water-consumption.php?date=...,
 * to persist the unit selected by the user.
 */
function createSessionForVolumeUnitSelected() {
    let unitSelected = document.getElementById('volumeUnitInWaterConsumptionModalInUserTrackWaterConsumptionView').value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("volumeUnitInUserTrackWaterConsumptionView=" + unitSelected);
}

/** Updates amount drank messages. */
function updateAmountDrankMessages() {
    
    // Formatted the date to be used for user readability.
    let currentDate = new Date();
    let currentDateString = currentDate.getDate() + "-" + (currentDate.getMonth() +  1) + "-" + currentDate.getFullYear();
    let paginationDate = new Date(currentPaginationDate);
    let paginationDateString = paginationDate.getDate() + "-" + (paginationDate.getMonth() +  1) + "-" + paginationDate.getFullYear();
    let amountDrankStatusMessage = document.getElementById('amountDrankStatusMessage');
    let amountDrankEncouragementMessage = document.getElementById('amountDrankEncouragementMessage');


    let amountDrankVolumeUnitSelected = document.getElementById("volumeUnitInUserTrackWaterConsumptionView").value;
    let totalAmountDrank = 0;

    for (let waterConsumptionID in waterConsumptionDataset) {
        if (waterConsumptionDataset.hasOwnProperty(waterConsumptionID)) {
            totalAmountDrank += Number(waterConsumptionDataset[waterConsumptionID]["amountDrankInMilliliter"]);
        }
    }

    let amountDrankInUnitText = convertValueOfMilliliterToValueUnit(Number(totalAmountDrank), amountDrankVolumeUnitSelected) + amountDrankVolumeUnitSelected;
    

    if (!isDatasetEmpty(waterConsumptionDataset)) {

        

        if (paginationDateString === currentDateString) {
            amountDrankStatusMessage.innerText = "You have drank " + amountDrankInUnitText + " today!";
            amountDrankEncouragementMessage.innerText = "Keep up the good work!";
        } else {
            amountDrankStatusMessage.innerText = "You have drank " + amountDrankInUnitText + " on " + paginationDateString;
            amountDrankEncouragementMessage.innerText = "";
        }
    } else {
        if (paginationDateString === currentDateString) {
            amountDrankStatusMessage.innerText = "You have drank " + amountDrankInUnitText + " today!";
            amountDrankEncouragementMessage.innerHTML = "Take a sip &#59;&#41;";
        } else {
            amountDrankStatusMessage.innerText = "You have drank " + amountDrankInUnitText + " on " + paginationDateString;
            amountDrankEncouragementMessage.innerHTML = "";
        }
    }
}

/** Opens the waterConsumptionDataModal to edit data. */
function openEditWaterConsumptionDataModal(waterConsumptionID) {
    let modal = document.getElementById('waterConsumptionDataModal');
    let overlay = document.getElementById('modalOverlay');
    let deleteWaterConsumptionDataButton = document.getElementById('deleteWaterConsumptionDataButton');
    let submitWaterConsumptionDataButton = document.getElementById('submitWaterConsumptionDataButton');
    let modalTitle = document.getElementById('modalTitle');
    let amountDrankInput = document.getElementById("amountDrank");
    let timeInput = document.getElementById('time');
    let waterConsumptionIDInput = document.getElementById('waterConsumptionID');

    volumeUnitSelected = document.getElementById("volumeUnitInUserTrackWaterConsumptionView").value;

    submitWaterConsumptionDataButton.value="Save"
    modalTitle.innerText = 'Edit Water Consumption Data';
    waterConsumptionIDInput.value = waterConsumptionID;

    amountDrankInput.value = convertValueOfMilliliterToValueUnit(Number(waterConsumptionDataset[waterConsumptionID]['amountDrankInMilliliter']), volumeUnitSelected);

    timeInput.value = waterConsumptionDataset[waterConsumptionID]["recordedOnTime"];

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    
    
    deleteWaterConsumptionDataButton.classList.remove('hidden');


    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

}
    

/** Opens waterConsumptionDataModal to add data. */
function openDeleteConfirmationModal() {
    let confirmationModal = document.getElementById('confirmationModal');

    confirmationModal.classList.remove('hidden');
    setTimeout(() => {
        confirmationModal.classList.add('show');
    }, 10);
}

/** Closes waterConsumptionDataModal. */
function closeConfirmationModal() {
    let confirmationModal = document.getElementById('confirmationModal');

    

    confirmationModal.classList.remove('show');


    setTimeout(() => {
        confirmationModal.classList.add('hidden');
    }, 300);
}




convertAmountDrankOfAllWaterConsumptionDataRow("volumeUnitInUserTrackWaterConsumptionView");
updateAmountDrankMessages();