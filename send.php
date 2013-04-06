<?php

//Put here the API token you get in the Pipedrive app
$TOKEN = "47bc4373557dd9ba1591902ec6aa1b928f0c6cdc";
//This is the URL for persons in the Pipedrive app. It'll add a new person with name, mail and phone
$url = "http://api.pipedrive.com/v1/persons?api_token=".$TOKEN;
$jsonData = array(
		"name"    => $_POST['name'],
		"email"   => array($_POST['email']),
		"phone"   => array($_POST['phone']),
		"city"    => "NewCity",
		"state"   => "NewState",
		"message" => "NewMessage",
);
$jsonData = json_encode($jsonData);
//Options for file_get_contents. We need to state method and content-type only.
$opts = array(
	"http" => array(
		"method"  => "POST",
		"header"  => "Content-Type: application/json",
		"content" => $jsonData
	)
);
$context = stream_context_create($opts);
$response = file_get_contents($url, false, $context );
//Show response in browser
print_r(json_decode($response));
?>
