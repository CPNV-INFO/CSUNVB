/**
 * Auteur:
 * Date: Décembre 2020
 **/


function cellUpdate(UID, time = '') {
    document.getElementById("save").removeAttribute("hidden");
    document.cookie = "drug" + UID + time + "=" + document.getElementById(UID + time).value;
    drugCheck(UID);
}

function sendData() {
    window.open("?action=updateDrugSheet", "_self");
}

function drugCheck(UID) {
    if(drugsheetmode !== "close") {
        let expectedAmount = Number(document.getElementById(UID + "start").value);
        let endAmount = Number(document.getElementById(UID + "end").value);

        //pharmacheck?
        if (UID.indexOf("pharma") !== -1) {
            let novaCells = document.querySelectorAll("." + UID + ".nova");
            //not cells.forEach because then no way to get value out of callback function
            for (let i = 0; i < novaCells.length; i++) {
                expectedAmount -= Number(novaCells[i].value);
            }
        }
        if (endAmount !== expectedAmount) {
            document.getElementById(UID).style = "background-color: orange;"
        } else {
            document.getElementById(UID).removeAttribute("style");
        }
    }else{
        let expectedAmount = Number(document.getElementById(UID + "start").textContent);
        let endAmount = Number(document.getElementById(UID + "end").textContent);

        //pharmacheck?
        if (UID.indexOf("pharma") !== -1) {
            let novaCells = document.querySelectorAll("." + UID + ".nova");
            //not cells.forEach because then no way to get value out of callback function
            for (let i = 0; i < novaCells.length; i++) {
                expectedAmount -= Number(novaCells[i].textContent);
            }
        }

        if (endAmount !== expectedAmount) {
            document.getElementById(UID).style = "background-color: orange;"
        } else {
            document.getElementById(UID).removeAttribute("style");
        }
    }
}

function drugListUpdate() {
    var drugList = document.getElementById('drugToAddList')
    var batchListOptions = document.getElementById('batchToAddList')

    batchListOptions.selectedIndex = 0

    for(var i = 1; i <= batchListOptions.length -1; i++){
        console.log("drug_"+ drugList.value)
        if(batchListOptions[i].classList.contains("drug_"+ drugList.value)){

            batchListOptions[i].hidden = false
        }else{
            batchListOptions[i].hidden = true
        }

    }
}

