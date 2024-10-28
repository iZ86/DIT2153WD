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

/** Opens waterConsumptionDataModal. */
function openAddWaterConsumptionModal() {
    const modal = document.getElementById('waterConsumptionDataModal');
    const overlay = document.getElementById('modalOverlay');
    let addWaterConsumptionDataButton = document.getElementById('addWaterConsumptionDataButton');
    let modalTitle = document.getElementById('modalTitle');

    modalTitle.innerText = 'Add Water Consumption Data';

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    addWaterConsumptionDataButton.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

/** Closes waterConsumptionDataModal. */
function closeAddWaterConsumptionModal() {
    const modal = document.getElementById('waterConsumptionDataModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    let addWaterConsumptionDataButton = document.getElementById('addWaterConsumptionDataButton');
    let deleteWaterConsumptionDataButton = document.getElementById('deleteWaterConsumptionDataButton');
    let saveWaterConsumptionDataButton = document.getElementById('saveWaterConsumptionDataButton');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        addWaterConsumptionDataButton.classList.add('hidden');
        deleteWaterConsumptionDataButton.classList.add('hidden');
        saveWaterConsumptionDataButton.classList.add('hidden');
    }, 300);
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
    return milliliters / MILLILITERSTOLITERSCONVERSIONRATE;
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

/** Opens the waterConsumptionDataModal for edit. */
function openEditWaterConsumptionDataModal(waterConsumptionID) {
    let modal = document.getElementById('waterConsumptionDataModal');
    let overlay = document.getElementById('modalOverlay');
    let deleteWaterConsumptionDataButton = document.getElementById('deleteWaterConsumptionDataButton');
    let saveWaterConsumptionDataButton = document.getElementById('saveWaterConsumptionDataButton');
    let modalTitle = document.getElementById('modalTitle');
    let amountDrankInput = document.getElementById("amountDrank");
    let timeInput = document.getElementById('time');

    unitSelected = document.getElementById("amountDrankUnit").value;


    modalTitle.innerText = 'Add Water Consumption Data';


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
    saveWaterConsumptionDataButton.classList.remove('hidden');


    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

}
    




convertAmountDrankOfAllWaterConsumptionDataRow("amountDrankUnit");
updateAmountDrankMessages();