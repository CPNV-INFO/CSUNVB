function showModal(){
    $("#mainModal").modal("toggle");
}

function setTitleModal(content){
    $("#mainModalTitle").html(content);
}

function addBodyModal(content){
    $("#mainModalBody").html($("#mainModalBody").html() + content);
}
function setBodyModal(content){
    $("#mainModalBody").html(content);
}
function setSubmitModal(content){
    $("#mainModalSubmit").html(content);
}

function shiftCommentModal(date,action,actionID,sheetID){
    $("#mainModalForm").attr('action', '?action=commentShift');
    setTitleModal("Remise de Garde du : " + date);
    setBodyModal("Ajouter un commentaire à " + action);
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value='+ sheetID +'>');
    addBodyModal('<input type="hidden" name="actionID" id="actionID" value='+ actionID +'>');
    addBodyModal('<input type="text" name="comment" id="comment" style="margin:10px 0px 0px 0px; width:400px;">');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Ajouter">');
    showModal();
}

function shiftCheckModal(date,action,actionID,sheetID,day){
    $("#mainModalForm").attr('action', '?action=checkShift');
    if(day == 1){
        var time = "jour";
    }else{
        var time = "nuit";
    }
    setTitleModal("Remise de Garde du : " + date);
    setBodyModal("Valider : " + action + " " + time);
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value='+ sheetID +'>');
    addBodyModal('<input type="hidden" name="actionID" id="actionID" value='+ actionID +'>');
    addBodyModal('<input type = "hidden" name="D/N" id="D/N" value="'+day+'">');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Valider">');
    showModal();
}

function shiftUnCheckModal(date,action,actionID,sheetID,day){
    $("#mainModalForm").attr('action', '?action=unCheckShift');
    if(day == 1){
        var time = "jour";
    }else{
        var time = "nuit";
    }
    setTitleModal("Remise de Garde du : " + date);
    setBodyModal("Retirer : " + action + " " + time);
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value='+ sheetID +'>');
    addBodyModal('<input type="hidden" name="actionID" id="actionID" value='+ actionID +'>');
    addBodyModal('<input type = "hidden" name="D/N" id="D/N" value="'+day+'">');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Retirer">');
    showModal();
}

function saveShiftModel(modelID){
    $("#mainModalForm").attr('action', '?action=addShiftModel');
    showModal();
}