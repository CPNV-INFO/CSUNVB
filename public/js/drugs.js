/**
 * Auteur:
 * Date: Décembre 2020
 **/


function cellUpdate(UID, time = '') {
    document.getElementById("save").removeAttribute("hidden");
    document.cookie = "drug" + UID + time + "=" + document.getElementById(UID + time).value;
    drugCheck(UID);
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
    let btnSwitchState = document.getElementById('btn_submit_SheetSwitchState');

    (novas.length >= 1 && batches.length >= 1) || btnSwitchState.textContent != "Activer" ? btnSwitchState.disabled = false : btnSwitchState.disabled = true;
}

function signDrugSheetDay(day,drugSheet){
    var confirm = window.confirm("Êtes vous bien sûr de vouloir signer cette journée ?");

    if(confirm === true){
        const form = document.createElement('form');
        form.method = "post";
        form.action = "?action=signDrugSheetDay";

        const drugSheetInput = document.createElement('input');
        drugSheetInput.type = 'hidden';
        drugSheetInput.name = 'drugSheetID';
        drugSheetInput.value = drugSheet;

        form.appendChild(drugSheetInput);

        const dayInput = document.createElement('input');
        dayInput.type = 'hidden';
        dayInput.name = 'day';
        dayInput.value = day;

        form.appendChild(dayInput);

        document.body.appendChild(form);

        form.submit();
    }

}

function createNewBatch(baseID,drugID){
    var batch = prompt("Numéro du lot");

    if(batch == null || batch == ""){


    }else {
        const form = document.createElement('form');
        form.method = "post";
        form.action = "?action=createBatch";

        const baseIDInput = document.createElement('input');
        baseIDInput.type = 'hidden';
        baseIDInput.name = 'baseID';
        baseIDInput.value = baseID;

        form.appendChild(baseIDInput);

        const drugIDInput = document.createElement('input');
        drugIDInput.type = 'hidden';
        drugIDInput.name = 'drugID';
        drugIDInput.value = drugID;

        form.appendChild(drugIDInput);

        const batchInput = document.createElement('input');
        batchInput.type = 'hidden';
        batchInput.name = 'batch';
        batchInput.value = batch;

        form.appendChild(batchInput);

        document.body.appendChild(form);

        form.submit();
    }
}