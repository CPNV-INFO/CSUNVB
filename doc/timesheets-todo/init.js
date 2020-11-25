project_id = 'XCLGRP1'
team = ["Michael", "Paola"]

inpProject.value = project_id

if (typeof(inpPerson) !== 'undefined') {
    team.forEach(element => {
        opt = document.createElement('option')
        opt.text = element
        inpPerson.appendChild(opt)
    });
}
