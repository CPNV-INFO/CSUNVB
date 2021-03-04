function showModal() {
    $("#mainModal").modal("toggle");
}

function setTitleModal(content) {
    $("#mainModalTitle").html(content);
}

function addBodyModal(content) {
    $("#mainModalBody").html($("#mainModalBody").html() + content);
}

function setBodyModal(content) {
    $("#mainModalBody").html(content);
}

function setSubmitModal(content) {
    $("#mainModalSubmit").html(content);
}

function shiftCommentModal(date, action, actionID, sheetID) {
    $("#mainModalForm").attr('action', '?action=commentShift');
    setTitleModal("Remise de Garde du : " + date);
    setBodyModal("Ajouter un commentaire à " + action);
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value=' + sheetID + '>');
    addBodyModal('<input type="hidden" name="actionID" id="actionID" value=' + actionID + '>');
    addBodyModal('<input type="text" name="comment" id="comment" style="margin:10px 0px 0px 0px; width:400px;">');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Ajouter">');
    showModal();
}

function shiftCheckModal(date, action, actionID, sheetID, day) {
    $("#mainModalForm").attr('action', '?action=checkShift');
    if (day == 1) {
        var time = "jour";
    } else {
        var time = "nuit";
    }
    setTitleModal("Remise de Garde du : " + date);
    setBodyModal("Valider : " + action + " " + time);
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value=' + sheetID + '>');
    addBodyModal('<input type="hidden" name="actionID" id="actionID" value=' + actionID + '>');
    addBodyModal('<input type = "hidden" name="D/N" id="D/N" value="' + day + '">');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Valider">');
    showModal();
}

function shiftUnCheckModal(date, action, actionID, sheetID, day) {
    $("#mainModalForm").attr('action', '?action=unCheckShift');
    if (day == 1) {
        var time = "jour";
    } else {
        var time = "nuit";
    }
    setTitleModal("Remise de Garde du : " + date);
    setBodyModal("Retirer : " + action + " " + time);
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value=' + sheetID + '>');
    addBodyModal('<input type="hidden" name="actionID" id="actionID" value=' + actionID + '>');
    addBodyModal('<input type = "hidden" name="D/N" id="D/N" value="' + day + '">');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Retirer">');
    showModal();
}

function saveShiftModel(sheetID, modelID) {
    $("#mainModalForm").attr('action', '?action=addShiftModel');
    setTitleModal("Enregistrer en tant que modèle");
    setBodyModal("Nom :<br>");
    addBodyModal('<input type="text" name="name" id="name" style="margin:10px 0px 0px 0px; width:400px;">');
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value=' + sheetID + '>');
    addBodyModal('<input type="hidden" name="modelID" id="modelID" value=' + modelID + '>');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Enregistrer">');
    showModal();
}

function disableShiftModel(modelID, modelName, sheetID) {
    $("#mainModalForm").attr('action', '?action=removeShiftModel');
    setTitleModal("Oublier le modèle");
    setBodyModal(modelName);
    addBodyModal('<input type="hidden" name="modelID" id="modelID" value=' + modelID + '>');
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value=' + sheetID + '>');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Oublier">');
    showModal();
}

function reAddShiftModel(modelID, modelName, sheetID) {
    $("#mainModalForm").attr('action', '?action=reAddShiftModel');
    setTitleModal("Réactiver le modèle");
    setBodyModal(modelName);
    addBodyModal('<input type="hidden" name="modelID" id="modelID" value=' + modelID + '>');
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value=' + sheetID + '>');
    setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Réactiver">');
    showModal();
}

function shiftClose(date, sheetID) {
    $("#mainModalForm").attr('action', '?action=shiftSheetSwitchState');
    setTitleModal("Remise de Garde du : " + date);
    setBodyModal("Etes-vous sur de vouloir clôturer ce rapport ?");
    $.ajax({
        type: "POST",
        url: '?action=uncheckActionForShift_AJAX&id=' + sheetID,
        cache: false,
        success: function (data) {
            if(data) addBodyModal("<br><br><strong>" + data + " tâche(s) n'ont pas été validée(s)</strong>");
        },
        error: function (jqXHR, exception) {
            alertError(jqXHR, exception);
        }
    });
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value=' + sheetID + '>');
    addBodyModal('<input type="hidden" name="newSlug" id="newSlug" value="close">');
    setSubmitModal('<input type="submit" class="btn btn-primary" value="Clôturer">');
    showModal();
}

function todoClose(sheetID) {
    $("#mainModalForm").attr('action', '?action=todoSheetSwitchState');
    setTitleModal("Tâches Hedomadaires");
    setBodyModal("Etes-vous sur de vouloir clôturer ce rapport ?");
    $.ajax({
        type: "POST",
        url: '?action=&id=' + sheetID,
        cache: false,
        success: function (data) {
            if(data) addBodyModal("<br><br><strong>" + data + " tâche(s) n'ont pas été validée(s)</strong>");
        },
        error: function (jqXHR, exception) {
            alertError(jqXHR, exception);
        }
    });
    addBodyModal('<input type="hidden" name="sheetID" id="sheetID" value=' + sheetID + '>');
    addBodyModal('<input type="hidden" name="newSlug" id="newSlug" value="close">');
    setSubmitModal('<input type="submit" class="btn btn-primary" value="Clôturer">');
    showModal();
}

