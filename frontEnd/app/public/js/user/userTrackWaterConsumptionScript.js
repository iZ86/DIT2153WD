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