let transactionHistoryDataset = JSON.parse(document.getElementById('phpTransactionHistoryDataset').value);

/** Redirects user to page. */
function goToPage(page) {
    location.href = "billing.php?date=" + page;
}

/** Extends the paymentID section. */
function extendPaymentIDSection(paymentID) {
    let expandablePaymentIDSection = document.getElementById(paymentID);
    let arrowText = document.getElementById(paymentID + "arrow");
    if (expandablePaymentIDSection.classList.contains("expandable--open")) {
        expandablePaymentIDSection.classList.remove("expandable--open");

        arrowText.classList.remove("rotate-90");
        arrowText.classList.add("rotate-180");
        
    } else {
        expandablePaymentIDSection.classList.add("expandable--open");
        
        arrowText.classList.remove("rotate-180");
        arrowText.classList.add("rotate-90");
    }
}

/** Displays all the details of the paymentID in their sections. */
function displayPaymentIDSectionDetails() {
    for (let i = 0; i < transactionHistoryDataset.length; i++) {
        let paymentID = transactionHistoryDataset[i]["payment"]["paymentID"];
        let paymentIDText = document.getElementById(paymentID + "paymentID");
        let descriptionText = document.getElementById(paymentID + "description");
        let dateText = document.getElementById(paymentID + "date");
        let statusText = document.getElementById(paymentID + "status");
        let amountText = document.getElementById(paymentID + "amount");
        let arrowText = document.getElementById(paymentID + "arrow");
        let paymentTypeText = document.getElementById(paymentID + "paymentType");
        let itemsDiv = document.getElementById(paymentID + "items");
        let totalAmountText = document.getElementById(paymentID + "totalAmount");

        paymentIDText.innerText = paymentID;
        descriptionText.innerText = transactionHistoryDataset[i]["items"][0].substring(0, transactionHistoryDataset[i]["items"][0].length > 10 ? 10 : transactionHistoryDataset[i]["items"][0].length + 1) + "..";
        dateText.innerText = transactionHistoryDataset[i]["payment"]["createdOn"];
        statusText.innerText = transactionHistoryDataset[i]["payment"]["status"];
        amountText.innerText = "RM" + transactionHistoryDataset[i]["totalAmount"];
        arrowText.innerText = ">";
        paymentTypeText.innerText = "Payment Type: " + transactionHistoryDataset[i]["payment"]["type"];

        let items = transactionHistoryDataset[i]["items"];
        for (let j = 0; j < items.length; j++) {
            itemText = document.createElement('p');
            itemText.classList.add("text-small");
            itemText.innerText = items[j];
            itemsDiv.appendChild(itemText);
        }

        totalAmountText.innerText = "Total Amount: RM" + transactionHistoryDataset[i]["totalAmount"];


    }
}



displayPaymentIDSectionDetails();