project_id = 'XCLGRP3'
team = ["Alexandre", "Loïc", "Jérémy"]

inpProject.value = project_id

if (typeof(inpPerson) !== 'undefined') {
    team.forEach(element => {
        opt = document.createElement('option')
        opt.text = element
        inpPerson.appendChild(opt)
    });
}
