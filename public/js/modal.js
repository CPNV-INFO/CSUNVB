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


var addShiftCommentBtns = document.querySelectorAll('.addShiftCommentBtn');
addShiftCommentBtns.forEach((item) => {
    item.addEventListener('click', function (event) {
        $("#mainModalForm").attr('action', '?action=commentShift');
        setTitleModal("Remise de Garde du : " + $("#shiftDate").val());
        setBodyModal("Ajouter un commentaire à  : " + $(this).parent().parent().find('.SH_actionName').html() + "<br>");
        addBodyModal('<input type="hidden" name="actionID" id="actionID" value=' + $(this).parent().parent().attr("value") + '>');
        addBodyModal('<input type="hidden" name="sheetID" id="todoSheetID" value=' + $("#sheetID").val() + '>');
        addBodyModal('<textarea rows="3" name="comment" id="comment" style="margin:10px 0 0 0; width:400px;"></textarea>');
        setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Valider">');
        showModal();
    }, false);
})

var checkShiftBtns = document.querySelectorAll('.checkShiftBtn');
checkShiftBtns.forEach((item) => {
    item.addEventListener('click', function (event) {
        $("#mainModalForm").attr('action', '?action=checkShift');
        var day = $(this).parent().attr("value");
        if (day == 1) {
            var time = "Jour";
        } else {
            var time = "Nuit";
        }
        setTitleModal("Remise de Garde du : " + $("#shiftDate").val());
        setBodyModal("Valider  : " + $(this).parent().parent().find('.SH_actionName').html() + " (" + time + ")<br>");
        addBodyModal('<input type="hidden" name="actionID" id="actionID" value=' + $(this).parent().parent().attr("value") + '>');
        addBodyModal('<input type="hidden" name="sheetID" id="todoSheetID" value=' + $("#sheetID").val() + '>');
        addBodyModal('<input type = "hidden" name="D/N" id="D/N" value="' + day + '">');
        setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Valider">');
        showModal();
    }, false);
})

var unCheckShiftBtns = document.querySelectorAll('.unCheckShiftBtn');
unCheckShiftBtns.forEach((item) => {
    item.addEventListener('click', function (event) {
        $("#mainModalForm").attr('action', '?action=unCheckShift');
        var day = $(this).parent().attr("value");
        if (day == 1) {
            var time = "Jour";
        } else {
            var time = "Nuit";
        }
        setTitleModal("Remise de Garde du : " + $("#shiftDate").val());
        setBodyModal("Retirer  : " + $(this).parent().parent().find('.SH_actionName').html() + " (" + time + ")<br>");
        addBodyModal('<input type="hidden" name="actionID" id="actionID" value=' + $(this).parent().parent().attr("value") + '>');
        addBodyModal('<input type="hidden" name="sheetID" id="todoSheetID" value=' + $("#sheetID").val() + '>');
        addBodyModal('<input type = "hidden" name="D/N" id="D/N" value="' + day + '">');
        setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Valider">');
        showModal();
    }, false);
})

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
            if(data > 0) addBodyModal("<br><br><strong>" + data + " tâche(s) n'ont pas été validée(s)</strong>");
        },
        error: function (jqXHR, exception) {
            alertError(jqXHR, exception);
        }
    });
    addBodyModal('<input type="hidden" name="id" id="sheetID" value=' + sheetID + '>');
    addBodyModal('<input type="hidden" name="newSlug" id="newSlug" value="close">');
    setSubmitModal('<input type="submit" class="btn btn-primary" value="Clôturer">');
    showModal();
}

function todoClose(sheetID,week) {
    $("#mainModalForm").attr('action', '?action=todoSheetSwitchState');
    setTitleModal("Tâches Hedomadaires : " + week);
    setBodyModal("Etes-vous sur de vouloir clôturer ce rapport ?");
    $.ajax({
        type: "POST",
        url: '?action=uncheckActionForTodo_AJAX&id=' + sheetID,
        cache: false,
        success: function (data) {
            if(data > 0) addBodyModal("<br><br><strong>" + data + " tâche(s) n'ont pas été validée(s)</strong>");
        },
        error: function (jqXHR, exception) {
            alertError(jqXHR, exception);
        }
    });
    addBodyModal('<input type="hidden" name="id" id="id" value=' + sheetID + '>');
    addBodyModal('<input type="hidden" name="newSlug" id="newSlug" value="close">');
    setSubmitModal('<input type="submit" class="btn btn-primary" value="Clôturer">');
    showModal();
}

// Code lié à la pop-up de vérification de validation de tâches
// Permet l'affichage de la pop-up de vérification pour les quitances
var addTaskBtns = document.querySelectorAll('.addTaskBtn');
addTaskBtns.forEach((item) => {
    item.addEventListener('click', function (event) {
        $("#mainModalForm").attr('action', '?action=checkTodo');
        setTitleModal($("#day-"+$(this).parent().attr("value")).html().replace('<br>', '') + " : " + $(this).parent().parent().attr("value"));
        setBodyModal("Valider : " + $(this).html().replace('<br>', ''));
        switch ($(this).attr("data-type")){
            case 'novas':
                addBodyModal('<br>Numéro de Novas :<br><input type="text" name="todoValue" id="todoValue" value="" placeholder="45, 34">');
                break;
            default:
        }
        addBodyModal('<input type="hidden" name="todoID" id="todoID" value=' + $(this).attr("data-id") + '>');
        addBodyModal('<input type="hidden" name="todoSheetID" id="todoSheetID" value=' + $("#sheetID").attr("value") + '>');
        setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Valider">');
        showModal();
    }, false);
})

var removeTaskBtns = document.querySelectorAll('.removeTaskBtn');
removeTaskBtns.forEach((item) => {
    item.addEventListener('click', function (event) {
        $("#mainModalForm").attr('action', '?action=unCheckTodo');
        setTitleModal($("#day-"+$(this).parent().attr("value")).html().replace('<br>', '') + " : " + $(this).parent().parent().attr("value"));
        setBodyModal("Annuler : " + $(this).html().replace('<br>', ''));
        addBodyModal('<input type="hidden" name="todoID" id="todoID" value=' + $(this).attr("data-id") + '>');
        addBodyModal('<input type="hidden" name="todoSheetID" id="todoSheetID" value=' + $("#sheetID").attr("value") + '>');
        setSubmitModal('<input type="submit" class="btn btn-primary" onclick="savePosY()" value="Annuler">');
        showModal();
    }, false);
})
