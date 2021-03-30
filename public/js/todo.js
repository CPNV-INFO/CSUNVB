/**
 * Le fichier contient les fonctionnalités javascript qui ne sont utilisées que pour les tâches hebdomadaires
 * Auteur: Vicky Butty
 * Date: Janvier 2021
 **/

window.onload = function ()
{
    showAddTodoBtn();
};

$( "#selectTodoModel").on( "change", function() {
    showAddTodoBtn();
});

function showAddTodoBtn(){
    if($("#selectTodoModel").val() !== 'undefined' && $("#selectTodoModel").val() !== null){
        $('#newTodoBtn').prop('disabled', false);
    }
}

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

var delTodoBtn = document.querySelectorAll('.delTodoTask');
delTodoBtn.forEach((item) => {
    item.addEventListener('click', function (event) {
        const param = {
            sheetID: $("#sheetID").val(),
            todoID: $(this).attr("data-id")
        };
        post("?action=delTodoTask", param )
    }, false);
})

