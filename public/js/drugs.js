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
    let drugList = document.getElementById('drugToAddList')
    let batchList = document.getElementById('batchToAddList')

    batchList.selectedIndex = 0

    for(let i = 1; i <= batchList.length -1; i++){

        batchList[i].classList.contains("drug_"+ drugList.value) ? batchList[i].hidden = false : batchList[i].hidden = true


    }

    batchSelectionMissing()
}

function batchSelectionMissing(){
    let batchList = document.getElementById('batchToAddList')
    let addBatchBtn = document.getElementById('addBatchBtn')

    batchList.selectedIndex !== 0 ? addBatchBtn.disabled = false : addBatchBtn.disabled = true

}

function NovaListUpdate(){
    let novaList = document.getElementById('novaToAddList')
    let addNovaBtn = document.getElementById('addNovaBtn')

    novaList.selectedIndex !== 0 ? addNovaBtn.disabled = false : addNovaBtn.disabled = true

}

function checkForEnable(){
    let novas = document.querySelectorAll(".novacount");
    let batches = document.querySelectorAll(".batchcount");
    let btnSwitchState = document.getElementById('btn_submit_SheetSwitchState')

    novas.length >= 1 && batches.length >= 1 ? btnSwitchState.disabled = false : btnSwitchState.disabled = true
}
