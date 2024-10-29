let waterConsumptionDataArray = JSON.parse(document.getElementById('phpArrayOfWaterConsumptionData').value);
let currentPaginationDate = JSON.parse(document.getElementById('currentPaginationDate').value);
const MILLILITERSTOLITERSCONVERSIONRATE = 1000;
const MILLILITERSTOOUNCESCONVERSIONRATE = 29.5735;

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
    if (unitDropDownBoxID === "amountDrankUnit") {
        document.getElementById('unit').value = document.getElementById("amountDrankUnit").value;
        
    } else if (unitDropDownBoxID === "unit") {
        document.getElementById('amountDrankUnit').value = document.getElementById("unit").value;
    }
    let unitSelected = document.getElementById('amountDrankUnit').value;


    if (unitSelected === "L") {
        Object.entries(waterConsumptionDataArray).map(entry => {
            let waterConsumptionData = entry[1];
            let amountDrank = convertMillilitersToLiters(new Number(waterConsumptionData["milliliters"]));
            let waterConsumptionDataRow = document.getElementById(waterConsumptionData["waterConsumptionID"] + "Text");
            waterConsumptionDataRow.innerText = "You have drank " + amountDrank + unitSelected + " at " + waterConsumptionData["recordedOnTime"];
        });
    
    } else if (unitSelected === "mL") {
        Object.entries(waterConsumptionDataArray).map(entry => {
            let waterConsumptionData = entry[1];
            let amountDrank = Number(waterConsumptionData["milliliters"]);
            let waterConsumptionDataRow = document.getElementById(waterConsumptionData["waterConsumptionID"] + "Text");
            waterConsumptionDataRow.innerText = "You have drank " + amountDrank + unitSelected + " at " + waterConsumptionData["recordedOnTime"];
        });
    } else if (unitSelected === "oz") {
        Object.entries(waterConsumptionDataArray).map(entry => {
            let waterConsumptionData = entry[1];
            let amountDrank = convertMillilitersToOunces(new Number(waterConsumptionData["milliliters"]));
            let waterConsumptionDataRow = document.getElementById(waterConsumptionData["waterConsumptionID"] + "Text");
            waterConsumptionDataRow.innerText = "You have drank " + amountDrank + unitSelected + " at " + waterConsumptionData["recordedOnTime"];
        });
    }
}

/** This function is used to send to track-water-consumption.php?date=...,
 * to persist the unit selected by the user.
 */
function createSessionForUnitSelected(unitDropDownBoxID) {
    let unitSelected = document.getElementById(unitDropDownBoxID).value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("unit=" + unitSelected);
}

/** Converts milliliters to liters. */
function convertMillilitersToLiters(milliliters) {
    return Math.floor(milliliters / MILLILITERSTOLITERSCONVERSIONRATE * 100) / 100;
}

/** Converts milliliters to ounces. */
function convertMillilitersToOunces(milliliters) {
    return Math.floor((milliliters / MILLILITERSTOOUNCESCONVERSIONRATE) * 100) / 100;
}

/** Updates amount drank messages. */
function updateAmountDrankMessages() {
    
    // Formatted the date to be used for user readability.
    let currentDate = new Date();
    let currentDateString = currentDate.getDate() + "-" + (currentDate.getMonth() +  1) + "-" + currentDate.getFullYear();
    let paginationDate = new Date(currentPaginationDate);
    let paginationDateString = paginationDate.getDate() + "-" + (paginationDate.getMonth() +  1) + "-" + paginationDate.getFullYear();

    let totalAmountDrank = 0;

    Object.entries(waterConsumptionDataArray).map(entry => {
        let waterConsumptionData = entry[1];
        totalAmountDrank += new Number(waterConsumptionData["milliliters"]);
    });
    let amountDrankStatusMessage = document.getElementById('amountDrankStatusMessage');
    let amountDrankEncouragementMessage = document.getElementById('amountDrankEncouragementMessage');

    let amountDrankInUnitText;
    let unitSelected = document.getElementById('amountDrankUnit').value;
    if (unitSelected === "mL") {
        amountDrankInUnitText = totalAmountDrank + "mL";
    } else if (unitSelected === "L") {
        amountDrankInUnitText = convertMillilitersToLiters(totalAmountDrank) + "L";
    } else if (unitSelected === "oz") {
        amountDrankInUnitText = convertMillilitersToOunces(totalAmountDrank) + "oz";
    } else {
        amountDrankInUnitText = "Error"
    }

    if (totalAmountDrank > 0) {
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

    unitSelected = document.getElementById("amountDrankUnit").value;

    submitWaterConsumptionDataButton.value="Save"
    modalTitle.innerText = 'Edit Water Consumption Data';
    waterConsumptionIDInput.value = waterConsumptionID;


    if (unitSelected === "mL") {
        amountDrankInput.value = waterConsumptionDataArray[waterConsumptionID]["milliliters"];
    } else if (unitSelected === "L") {
         amountDrankInput.value = convertMillilitersToLiters(new Number(waterConsumptionDataArray[waterConsumptionID]['milliliters']));
    } else if (unitSelected === "oz") {
        amountDrankInput.value = convertMillilitersToOunces(new Number(waterConsumptionDataArray[waterConsumptionID]['milliliters']));
    }
    timeInput.value = waterConsumptionDataArray[waterConsumptionID]["recordedOnTime"];

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
        clearModalFields();
    }, 300);
}




convertAmountDrankOfAllWaterConsumptionDataRow("amountDrankUnit");
updateAmountDrankMessages();