/**
 * Le fichier contient les fonctionnalités javascript qui ne sont utilisées que pour les tâches hebdomadaires
 * Auteur: Vicky Butty
 * Date: Janvier 2021
 **/


// Code lié à la pop-up de vérification de suppression de tâches
// Permet l'affichage de la pop-up de vérification pour la suppression des tâches
var trashButtons = document.querySelectorAll('.trashButtons');

trashButtons.forEach((item) => {
    item.addEventListener('click', function (event) {
        $("#deletingTaskModal").modal("toggle");
        document.getElementById("modal-deletingTitle").innerHTML = this.getAttribute("data-title");
        document.getElementById("modal-deletingContent").innerHTML = this.getAttribute("data-content");
        document.getElementById("modal-deletingTaskID").value = this.getAttribute("data-id");

    }, false);
})

$( "#selectDay").on( "change", function() {
    showAddTask();
});

$( "#selectTime").on( "change", function() {
    showAddTask();
});

function showAddTask(){
    var day = $("#selectDay").val();
    var time = $("#selectTime").val();
    if(day != null && time != null){
        $.ajax({
            type: "POST",
            url: "?action=findMissingTasks_AJAX",
            data: {
                day: day,
                time: time,
                sheetID: $("#sheetID").val()
            },
            cache: false,
            success: function(data) {
                $("#missingTask").html(data);
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
        $( "#editSheetForm" ).removeClass( "inactivForm" )
    }else{
        $( "#editSheetForm" ).addClass( "inactivForm" )
    }
}

$( "#addOldTask").on( "click", function() {
    const param = {
        day: $("#selectDay").val(),
        sheetID: $("#sheetID").val(),
        taskID: $("#missingTask").val()
    };
    post("?action=oldTodoTask", param )

});

$( "#addNewTask").on( "click", function() {
    const param = {
        day: $("#selectDay").val(),
        time: $("#selectTime").val(),
        sheetID: $("#sheetID").val(),
        name: $("#newTask").val()
    };
    post("?action=newTodoTask", param )
});
