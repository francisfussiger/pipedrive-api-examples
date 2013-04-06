<pre>
<?php
//Get the token and put on config.php
require "config.php";
//First, verify if app alredy has the new person fields
//This is the URL for personFields in the Pipedrive app. It should return the number of fields
$url = "http://api.pipedrive.com/v1/personFields?api_token=".$TOKEN;
$opts = array(
	"http" => array(
		"method"  => "GET",
		"header"  => "Content-Type: application/json"
	)
);
$context = stream_context_create($opts);
$response = file_get_contents($url, false, $context );
//If no response comes, it means there is no API token.
if (!$response){
	echo "Please put the API Token in config.php!";
	exit;
}
$response = json_decode($response);
$pipedriveData = array();
//Looks for keys of custom fields
if (count($response->data)!=11){
	foreach ($response->data as $data){
		if (strlen($data->key) == 40){
			array_push($pipedriveData, $data->key);
		}
	}
}
//This is the URL for persons in the Pipedrive app. It'll add a new person with name, mail and phone
$url = "http://api.pipedrive.com/v1/persons?api_token=".$TOKEN;
$jsonData = array(
		"name"    => $_POST['name'],
		"email"   => array($_POST['email']),
		"phone"   => array($_POST['phone']),
);
//For each custom field, add the data in the index.php field
if (count($pipedriveData)>0){
	foreach ($pipedriveData as $dataString){
		$jsonData[$dataString] = $_POST[$dataString];
	}
}
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
echo "Success!";
?>
</pre>