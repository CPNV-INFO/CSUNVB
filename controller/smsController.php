<?php

function sendSms($number,$message){
    require_once ".const.php";
    $ch = curl_init();

    $curl_url = 'https://api.smsportal.ch/sendsms';

    $json = '{
	"auth"	:{
						"username": "'.SMS_USERNAME.'",
						"password": "'.SMS_PASSWORD.'"
					},
	"sender" :"CSUNVB",
	"receiver":"'.$number.'",
	"text":    "'.$message.'",
	"dlrMask": "18",
	"dlrUrl":  ""
}';

    curl_setopt($ch,CURLOPT_URL, $curl_url);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$json);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

//execute post
    $result = curl_exec($ch);

    curl_close($ch);

    return $result;

}
