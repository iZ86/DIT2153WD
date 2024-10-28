let waterConsumptionDataArray = JSON.parse(document.getElementById('phpArrayOfWaterConsumptionData').value);
let currentPaginationDate = JSON.parse(document.getElementById('currentPaginationDate').value);
const MILLILITERSTOLITERSCONVERSIONRATE = 1000;

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

/** Opens addWaterConsumptionModal. */
function openAddWaterConsumptionModal() {
    const modal = document.getElementById('addWaterConsumptionModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

/** Closes addWaterConsumptionModal. */
function closeAddWaterConsumptionModal() {
    const modal = document.getElementById('addWaterConsumptionModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
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
        for (let i = 0; i < waterConsumptionDataArray.length; i++) {
            let amountDrank = convertMillilitersToLiters(new Number(waterConsumptionDataArray[i]["milliliters"]));
            let waterConsumptionDataRow = document.getElementById(waterConsumptionDataArray[i]["waterConsumptionID"]);
            waterConsumptionDataRow.innerText = "You have drank " + amountDrank + unitSelected + " at " + waterConsumptionDataArray[i]["recordedOnTime"];
        }
        
    } else if (unitSelected === "mL") {
        for (let i = 0; i < waterConsumptionDataArray.length; i++) {
            let amountDrank = Number(waterConsumptionDataArray[i]["milliliters"]);
            let waterConsumptionDataRow = document.getElementById(waterConsumptionDataArray[i]["waterConsumptionID"]);
            waterConsumptionDataRow.innerText = "You have drank " + amountDrank + unitSelected + " at " + waterConsumptionDataArray[i]["recordedOnTime"];
        }
    } else if (unitSelected === "oz") {
        for (let i = 0; i < waterConsumptionDataArray.length; i++) {
            let amountDrank = Math.floor((Number(waterConsumptionDataArray[i]["milliliters"]) / 29.5735) * 100) / 100;
            let waterConsumptionDataRow = document.getElementById(waterConsumptionDataArray[i]["waterConsumptionID"]);
            waterConsumptionDataRow.innerText = "You have drank " + amountDrank + unitSelected + " at " + waterConsumptionDataArray[i]["recordedOnTime"];
        }
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

