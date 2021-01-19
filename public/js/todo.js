/**
 * Le fichier contient les fonctionnalités javascript qui ne sont utilisées que pour les tâches hebdomadaires
 * Auteur: Vicky Butty
 * Date: Janvier 2021
 **/

// Code lié à la pop-up de vérification de validation de tâches
var buttons = document.querySelectorAll('.toggleTodoModal');

buttons.forEach((item) => {
    item.addEventListener('click', function (event) {
        $("#todoModal").modal("toggle");
        document.getElementById("modal-validationTitle").innerHTML = this.getAttribute("data-title");
        document.getElementById("modal-validationContent").innerHTML = this.getAttribute("data-content");
        document.getElementById("modal-todoID").value = this.getAttribute("data-id");

        var status = this.getAttribute("data-status"); // 'validate' si la tache n'est pas validée, 'unvalidate' dans le cas contraire
        var type = this.getAttribute("data-type");

        if(type == "2" && status == "validate"){
            document.getElementById("modal-todoValue").type = "text";
            document.getElementById("modal-todoValue").required = true;
        }else{
            document.getElementById("modal-todoValue").type = "hidden";
            document.getElementById("modal-todoValue").required = false;
        }

        document.getElementById("modal-todoType").value = type;
        document.getElementById("modal-todoStatus").value = status;

    }, false);
})
console.log(buttons.length);


// Code lié à la pop-up de vérification de suppression de tâches
var trashButtons = document.querySelectorAll('.trashButtons');

trashButtons.forEach((item) => {
    item.addEventListener('click', function (event) {
        $("#deletingTaskModal").modal("toggle");
        document.getElementById("modal-deletingTitle").innerHTML = this.getAttribute("data-title");
        document.getElementById("modal-deletingContent").innerHTML = this.getAttribute("data-content");
        document.getElementById("modal-deletingTaskID").value = this.getAttribute("data-id");

    }, false);
})