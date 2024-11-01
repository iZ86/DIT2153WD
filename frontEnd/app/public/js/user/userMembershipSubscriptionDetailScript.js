let fitnessClassDataset = JSON.parse(document.getElementById('phpFitnessClassDataset').value);
let membershipData = JSON.parse(document.getElementById('phpMembershipData').value);


/** Renders the fitness class detail. */
function renderFitnessClassDetail(fitnessClassID) {
    

    let fitnessClassSelection = document.getElementById(fitnessClassID + "ClassSelection");
    let fitnessClassDetailContent = document.getElementById('fitnessClassDetail');


    // If has not been selected, and its been pressed, display class details.
    if (!fitnessClassSelection.classList.contains("border-emerald-400")) {

        // Sets a emerald border on the class button, to let user to know which class detail they're viewing.
        for (let fitnessClassDataID in fitnessClassDataset) {
            if (fitnessClassDataset.hasOwnProperty(fitnessClassDataID)) {

                let fitnessClassSelection = document.getElementById(fitnessClassDataset + "ClassSelection");
                fitnessClassSelection = document.getElementById(fitnessClassDataID + "ClassSelection");

                if ((Number(fitnessClassID)) === (Number(fitnessClassDataID))) {
                    fitnessClassSelection.classList.add("border-4");
                    fitnessClassSelection.classList.add("border-emerald-400");
                } else {
                    fitnessClassSelection.classList.remove("border-4");
                    fitnessClassSelection.classList.remove("border-emerald-400");
                }
            }
        }


        // Set the class detail properties
        let fitnessClassDetailName = document.getElementById('fitnessClassDetailName');
        let fitnessClassImage = document.getElementById('fitnessClassImage');
        let fitnessClassDescription = document.getElementById('fitnessClassDescription');
        let fitnessClassDetailPrice = document.getElementById('fitnessClassDetailPrice');
        let fitnessClassDetailID = document.getElementById('fitnessClassDetailID');

        fitnessClassDetailID.value = fitnessClassID;

        fitnessClassDetailName.innerText = fitnessClassDataset[fitnessClassID]["name"];
        let currentLocation = window.location.href;
        let endIndex = 0;
        for (let k = 0; k < currentLocation.length; k++ ) {
            if (currentLocation.at(k) === "?") {
                endIndex = k;
                break;
            }
        }
        fitnessClassImage.src = window.location.href.substring(0, endIndex) + "/../" + fitnessClassDataset[fitnessClassID]['fitnessClassImageFilePath'];
        fitnessClassDescription.innerText = fitnessClassDataset[fitnessClassID]["description"];
        fitnessClassDetailPrice.innerText = "RM" + fitnessClassDataset[fitnessClassID]["price"] + " per month";


        
        let addFitnessClassCheckBox = document.getElementById(fitnessClassDetailID.value);
        let addFitnessClassSelectionButton = document.getElementById('addFitnessClassSelectionButton');
        let removeFitnessClassSelectionButton = document.getElementById('removeFitnessClassSelectionButton');

        if (addFitnessClassCheckBox.checked) {
            addFitnessClassSelectionButton.classList.add('hidden');
            removeFitnessClassSelectionButton.classList.remove('hidden');
        } else {
            addFitnessClassSelectionButton.classList.remove('hidden');
            removeFitnessClassSelectionButton.classList.add('hidden');
        }

        fitnessClassDetailContent.classList.remove("invisible");





    } else {
        fitnessClassSelection.classList.remove("border-4");
        fitnessClassSelection.classList.remove("border-emerald-400");
        fitnessClassDetailContent.classList.add("invisible");
    }
}

/** Removes the fitness class selection, unchecking the checkbox. */
function removeFitnessClassSelection() {
    let fitnessClassDetailID = document.getElementById('fitnessClassDetailID');
    let addFitnessClassCheckBox = document.getElementById(fitnessClassDetailID.value);
    addFitnessClassCheckBox.checked = false;

    let addFitnessClassSelectionButton = document.getElementById('addFitnessClassSelectionButton');
    let removeFitnessClassSelectionButton = document.getElementById('removeFitnessClassSelectionButton');
    addFitnessClassSelectionButton.classList.remove('hidden');
    removeFitnessClassSelectionButton.classList.add('hidden');
}

/** Removes the fitness class selection, checking the checkbox. */
function addFitnessClassSelection() {
    let fitnessClassDetailID = document.getElementById('fitnessClassDetailID');
    let addFitnessClassCheckBox = document.getElementById(fitnessClassDetailID.value);
    addFitnessClassCheckBox.checked = true;

    let addFitnessClassSelectionButton = document.getElementById('addFitnessClassSelectionButton');
    let removeFitnessClassSelectionButton = document.getElementById('removeFitnessClassSelectionButton');
    removeFitnessClassSelectionButton.classList.remove('hidden');
    addFitnessClassSelectionButton.classList.add('hidden');

}

/** Proceeds user to payment. */
function proceedToPayment() {
    let paymentRequest = "payment.php?membershipID=" + membershipData["membershipID"];
    for (let fitnessClassID in fitnessClassDataset) {
        let fitnessClassCheckBox = document.getElementById(fitnessClassID);
        if (fitnessClassCheckBox.checked) {
            paymentRequest += "&" + fitnessClassDataset[fitnessClassID]["name"] + "=" + 1;
        }
    }
    location.href = paymentRequest;
}
