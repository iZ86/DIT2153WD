let exerciseRoutineDetailDataset = JSON.parse(document.getElementById('phpExerciseRoutineDetailDataset').value);
let exerciseDataset = JSON.parse(document.getElementById("phpExerciseDataset").value);
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
function redirectTrackExerciseRoutineDetailPage() {
    let dateInput = document.getElementById("dateOfExerciseRoutineDetail");
    location.href = "track-exercise-routine-detail.php?date=" + dateInput.value;
}

/** Redirects the user to the same website with GET request to the previous date. */
function previousDate() {
    let dateInput = document.getElementById("dateOfExerciseRoutineDetail");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() - 1);
    location.href = "track-exercise-routine-detail.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
}

/** Redirects the user to the same website with GET request to the next date. */
function nextDate() {
    let dateInput = document.getElementById("dateOfExerciseRoutineDetail");
    let date = new Date(dateInput.value);
    date.setDate(date.getDate() + 1);
    location.href = "track-exercise-routine-detail.php?date=" + date.getFullYear() + "-" + (date.getMonth() +  1)+ "-" + date.getDate();
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

/** Opens exerciseRoutineDetailDataModal to add data. */
function openAddExerciseRoutineDetailDataModal() {
    const modal = document.getElementById('exerciseRoutineDetailDataModal');
    const overlay = document.getElementById('modalOverlay');
    let submitExerciseRoutineDetailDataButton = document.getElementById('submitExerciseRoutineDetailDataButton');
    let exerciseRoutineDetailDataModalTitle = document.getElementById('exerciseRoutineDetailDataModalTitle');
    submitExerciseRoutineDetailDataButton.value="Add";
    exerciseRoutineDetailDataModalTitle.innerText = 'Add Exercise Routine Detail Data';

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

/** Closes exerciseRoutineDetailDataModal. */
function closeExerciseRoutineDetailDataModal() {
    const modal = document.getElementById('exerciseRoutineDetailDataModal');
    const overlay = document.getElementById('modalOverlay');

    modal.classList.remove('show');

    
    let deleteExerciseRoutineDetailDataButton = document.getElementById('deleteExerciseRoutineDetailDataButton');

    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        deleteExerciseRoutineDetailDataButton.classList.add('hidden');
        clearModalFields();
    }, 300);
}

/** Clear modal fields. */
function clearModalFields() {
    document.getElementById('exerciseRoutineDetailID').value = "";
    document.getElementById('exerciseIDForExerciseRoutineDetail').value = -1;
    document.getElementById('weight').value = "";
    document.getElementById('rep').value = "";
    document.getElementById('note').value = "";
    document.getElementById('time').value = "";
}

/** Display message for all the exercise routine detail data row. */
function displayMessageOfAllExerciseRoutineDetailDataRow() {
    Object.entries(exerciseRoutineDetailDataset).map(entry => {
        let exerciseRoutineDetailData = entry[1];
        let exerciseRoutineDetailDataRowText =  document.getElementById(exerciseRoutineDetailData["exerciseRoutineDetailID"] + "Text");
        exerciseRoutineDetailDataRowText.innerText = "You did " + exerciseDataset[exerciseRoutineDetailData["exerciseID"]]["exerciseName"] +
        " at " + exerciseRoutineDetailData["recordedOnTime"];
    });
}

/** This function is used to send to track-exercise-routine-detail.php?date=...,
 * to persist the unit selected by the user.
 */
function createSessionForWeightUnitSelected() {
    let unitSelected = document.getElementById('weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView').value;
    xmlHttRequest = new XMLHttpRequest();
    xmlHttRequest.open("POST", window.location.href, true);
    xmlHttRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlHttRequest.send("weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView=" + unitSelected);
}

/** Updates exercise routine detail messages. */
function updateExerciseRoutineDetailMessages() {
    
    // Formatted the date to be used for user readability.
    let currentDate = new Date();
    let currentDateString = currentDate.getDate() + "-" + (currentDate.getMonth() +  1) + "-" + currentDate.getFullYear();
    let paginationDate = new Date(currentPaginationDate);
    let paginationDateString = paginationDate.getDate() + "-" + (paginationDate.getMonth() +  1) + "-" + paginationDate.getFullYear();
    let exerciseRoutineDetailStatusMessage = document.getElementById("exerciseRoutineDetailStatusMessage");
    let exerciseRoutineDetailEncouragementMessage = document.getElementById("exerciseRoutineDetailEncouragementMessage");


    

    if (!isDatasetEmpty(exerciseRoutineDetailDataset)) {

        // Start of time.
        let exerciseRoutineDetailTime = "00:00";
        // It will be defined later on, in the for loop, and it is guranteed, since it is not empty due to the check earlier.
        let exerciseRoutineDetailID;

        // exerciseRoutineDetailDataID is exerciseRoutineDetailID, just a placeholder name.
        // Trying to get the most latest exerciseRoutineLatestID.
        for (let exerciseRoutineDetailDataID in exerciseRoutineDetailDataset) {
            if (exerciseRoutineDetailDataset.hasOwnProperty(exerciseRoutineDetailDataID)) {
                if (exerciseRoutineDetailDataset[exerciseRoutineDetailDataID]["recordedOnTime"] > exerciseRoutineDetailTime) {
                    exerciseRoutineDetailTime = exerciseRoutineDetailDataset[exerciseRoutineDetailDataID]["recordedOnTime"];
                    exerciseRoutineDetailID = exerciseRoutineDetailDataID;
                }
            }
        }

        let exerciseData = exerciseDataset[exerciseRoutineDetailDataset[exerciseRoutineDetailID]["exerciseID"]];
        let exerciseName = exerciseData["exerciseName"];

        if (paginationDateString === currentDateString) {
            exerciseRoutineDetailStatusMessage.innerText = "Your latest exercise today is " + exerciseName + " with " + exerciseRoutineDetailDataset[exerciseRoutineDetailID][rep] + " reps!";
            exerciseRoutineDetailEncouragementMessage.innerText = "Keep up the good work!";
        } else {
            exerciseRoutineDetailStatusMessage.innerText = "You latest exercise on " + paginationDateString + " is " + exerciseName + "!";
            exerciseRoutineDetailEncouragementMessage.innerText = "";
        }
    } else {
        if (paginationDateString === currentDateString) {
            exerciseRoutineDetailStatusMessage.innerText = "You did not exercise today!";
            exerciseRoutineDetailEncouragementMessage.innerHTML = "Is today a rest day?";
        } else {
            exerciseRoutineDetailStatusMessage.innerText = "You did not exercise on " + paginationDateString;
            exerciseRoutineDetailEncouragementMessage.innerHTML = "Perhaps it was a rest day.";
        }
    }
}

/** Opens the exerciseRoutineDetailDataModal to edit exercise routine detail data. */
function openEditExerciseRoutineDetailDataModal(exerciseRoutineDetailID) {
    let modal = document.getElementById('exerciseRoutineDetailDataModal');
    let overlay = document.getElementById('modalOverlay');
    let exerciseRoutineDetailDataModalTitle = document.getElementById('exerciseRoutineDetailDataModalTitle');
    let deleteExerciseRoutineDetailDataButton = document.getElementById('deleteExerciseRoutineDetailDataButton');
    let submitExerciseRoutineDetailDataButton = document.getElementById('submitExerciseRoutineDetailDataButton');
    

    let exerciseRoutineDetailIDInput = document.getElementById('exerciseRoutineDetailID');
    let exerciseInput = document.getElementById('exerciseIDForExerciseRoutineDetail');
    let weightInput = document.getElementById('weight');
    let weightUnitSelected = document.getElementById('weightUnitInExerciseRoutineDetailDataModalInUserTrackExerciseRoutineDetailView').value;
    let repInput = document.getElementById('rep');
    let noteInput = document.getElementById('note');
    let timeInput = document.getElementById('time');


    
    exerciseRoutineDetailDataModalTitle.innerText = 'Edit Exercise Routine Detail Data';
    deleteExerciseRoutineDetailDataButton.classList.remove('hidden');
    submitExerciseRoutineDetailDataButton.value="Save"


    exerciseRoutineDetailIDInput.value = exerciseRoutineDetailID;
    exerciseInput.value = exerciseRoutineDetailDataset[exerciseRoutineDetailID]["exerciseID"];
    repInput.value = exerciseRoutineDetailDataset[exerciseRoutineDetailID]["rep"];
    if (exerciseRoutineDetailDataset[exerciseRoutineDetailID]["note"] === undefined) {
        noteInput.value = "";
    } else {
        noteInput.value = exerciseRoutineDetailDataset[exerciseRoutineDetailID]["note"];
    }
    
    weightInput.value = convertValueOfGramToWeightUnit(Number(exerciseRoutineDetailDataset[exerciseRoutineDetailID]["weightInGram"]), weightUnitSelected);

    
    timeInput.value = exerciseRoutineDetailDataset[exerciseRoutineDetailID]["recordedOnTime"];
    

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    

    setTimeout(() => {
        modal.classList.add('show');
    }, 10);

}
    

/** Opens deleteExerciseRoutineDetailDataConfirmationModal. */
function openDeleteExerciseRoutineDetailDataConfirmationModal() {
    let deleteExerciseRoutineDetailDataConfirmationModal = document.getElementById('deleteExerciseRoutineDetailDataConfirmationModal');

    deleteExerciseRoutineDetailDataConfirmationModal.classList.remove('hidden');
    setTimeout(() => {
        deleteExerciseRoutineDetailDataConfirmationModal.classList.add('show');
    }, 10);
}

/** Closes deleteExerciseRoutineDetailDataConfirmationModal. */
function closeDeleteExerciseRoutineDetailDataConfirmationModal() {
    let deleteExerciseRoutineDetailDataConfirmationModal = document.getElementById('deleteExerciseRoutineDetailDataConfirmationModal');

    deleteExerciseRoutineDetailDataConfirmationModal.classList.remove('show');


    setTimeout(() => {
        deleteExerciseRoutineDetailDataConfirmationModal.classList.add('hidden');
    }, 300);
}

/** Updates the select tag with id exerciseID. */
function updateExerciseIDInput() {
    let exerciseIDInput = document.getElementById("exerciseID");

    if (isDatasetEmpty(exerciseDataset)) {
        let messageOption = new Option("Add an exercise", -1, true, true);
        messageOption.disabled = true;
        exerciseIDInput.options[0] = messageOption;
    } else {

        let messageOption = new Option("Select an exercise", -1, true, true);
        messageOption.disabled = true;
        exerciseIDInput.options[0] = messageOption;

        for (let exerciseDataID in exerciseDataset) {
            if (exerciseDataset.hasOwnProperty(exerciseDataID)) {
                exerciseIDInput.options[exerciseIDInput.length] = new Option(exerciseDataset[exerciseDataID]["exerciseName"], exerciseDataID);
            }
        }
    }
}

/** Updates the select tag with id exerciseIDForExerciseRoutineDetail */
function updateExerciseIDForExerciseRoutineDetail() {
    let exerciseIDForExerciseRoutineDetailInput = document.getElementById("exerciseIDForExerciseRoutineDetail");

    if (isDatasetEmpty(exerciseDataset)) {
        let messageOption = new Option("Add an exercise", -1, true, true);
        messageOption.disabled = true;
        exerciseIDForExerciseRoutineDetailInput.options[0] = messageOption;
    } else {

        let messageOption = new Option("Select an exercise", -1, true, true);
        messageOption.disabled = true;
        exerciseIDForExerciseRoutineDetailInput.options[0] = messageOption;

        for (let exerciseDataID in exerciseDataset) {
            if (exerciseDataset.hasOwnProperty(exerciseDataID)) {
                exerciseIDForExerciseRoutineDetailInput.options[exerciseIDForExerciseRoutineDetailInput.length] = new Option(exerciseDataset[exerciseDataID]["exerciseName"], exerciseDataID);
            }
        }
    }
}

/** Opens exerciseDataModal to add data. */
function openAddExerciseDataModal() {
    const modal = document.getElementById('exerciseDataModal');
    const overlay = document.getElementById('modalOverlay');
    let submitExerciseDataButton = document.getElementById('submitExerciseDataButton');
    let exerciseDataModalTitle = document.getElementById('exerciseDataModalTitle');

    submitExerciseDataButton.value="Add";
    exerciseDataModalTitle.innerText = 'Add Exercise Data';

    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('show');
    }, 10);
}

/** Closes exerciseDataModal. */
function closeExerciseDataModal() {
    const modal = document.getElementById('exerciseDataModal');
    const overlay = document.getElementById('modalOverlay');
    let deleteExerciseDataButton = document.getElementById('deleteExerciseDataButton');

    modal.classList.remove('show');

    
    setTimeout(() => {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
        deleteExerciseDataButton.classList.add('hidden');
        clearModalFields();
    }, 300);
}

/** Opens the exerciseDataModal to edit exercise data. */
function openEditExerciseDataModal() {
    let exerciseIDInput = document.getElementById("exerciseID");
    if ((Number(exerciseIDInput.value)) === -1) {
        alert("Please select an exercise!");
    } else {
        let modal = document.getElementById('exerciseDataModal');
        let overlay = document.getElementById('modalOverlay');
        let deleteExerciseDataButton = document.getElementById('deleteExerciseDataButton');
        let exerciseDataModalTitle = document.getElementById('exerciseDataModalTitle');
        let submitExerciseDataButton = document.getElementById('submitExerciseDataButton');
        

        let exerciseNameInput = document.getElementById('exerciseName');


        
        exerciseDataModalTitle.innerText = 'Edit Exercise Data';
        submitExerciseDataButton.value="Save"


        exerciseNameInput.value = exerciseDataset[exerciseIDInput.value]["exerciseName"];

        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');
        deleteExerciseDataButton.classList.remove('hidden');
        

        setTimeout(() => {
            modal.classList.add('show');
        }, 10);

    }
}

/** Opens deleteExerciseDataConfirmationModal. */
function openDeleteExerciseDataConfirmationModal() {
    let deleteExerciseDataConfirmationModal = document.getElementById('deleteExerciseDataConfirmationModal');
    let overlay = document.getElementById('modalOverlay');

    deleteExerciseDataConfirmationModal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    setTimeout(() => {
        deleteExerciseDataConfirmationModal.classList.add('show');
    }, 10);
}

/** Closes deleteExerciseDataConfirmationModal. */
function closeDeleteExerciseDataConfirmationModal() {
    
    let overlay = document.getElementById('modalOverlay');
    let deleteExerciseDataConfirmationModal = document.getElementById('deleteExerciseDataConfirmationModal');

    deleteExerciseDataConfirmationModal.classList.remove('show');

    setTimeout(() => {
        deleteExerciseDataConfirmationModal.classList.add('hidden');
        overlay.classList.add('hidden');
    }, 300);
}



updateExerciseIDForExerciseRoutineDetail();
updateExerciseIDInput();
displayMessageOfAllExerciseRoutineDetailDataRow();
updateExerciseRoutineDetailMessages();