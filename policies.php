<?php
/**
 * File : policies.php
 * Author : X. Carrel
 * Created : 18.12.20
 * Modified last : 27.04.21 MGT
 **/

// the array is a list of actions that need permissions to be execute
// the user logged in has an 'admin' field, numeric:

return [
    //action only for admin
    "1" => [
        //shift
        "updateShift",
        "addActionForShift",
        "creatActionForShift",
        "removeActionForShift",
        //todos

        //drugs

        //admin
        "adminHome",
        "adminCrew",
        "newUser",
        "saveNewUser",
        "changeUserAdmin",
        "resetUserPassword",
        "adminDrugs",
        "newDrug",
        "updateDrug",
        "adminBases",
        "newBase",
        "editbase",
        "updateBase",
        "adminNovas",
        "newNova",
        "updateNova",
        "changeEmail",
        "changeTel"

        //main

    ]
];
