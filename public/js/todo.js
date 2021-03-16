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

// Code lié aux listes de tâches manquantes (Ajout de tâche)
// Permet l'affichage des listes déroulantes en fonction des choix de jour et créneau
var dropdownLists = document.querySelectorAll('.missingTasksChoice');

dropdownLists.forEach((item) => {
    item.addEventListener('change', function (event) {

        var day = document.getElementById('missingTaskDay').value;
        var time = document.getElementById('missingTaskTime').value;

        var elements = document.getElementsByClassName('missingTodoTaskList');
        var label = document.getElementById('missingTaskLabel');
        var button = document.getElementById('addTodoTaskBtn');

        for (var i = 0; i < elements.length; i ++) {
            elements[i].classList.add('d-none');
        }

        if(day != 'default' && time != 'default'){
            var id = "day"+day+"time"+time;
            document.getElementById(id).classList.remove('d-none');
            label.classList.remove('d-none');
            button.disabled = false;
        }else{
            label.classList.add('d-none');
            button.disabled = true;
        }

    }, false);
})

