<?php require "config.php" ?>
<!DOCTYPE html>
<html>
<head>
<title>Form do pipedrive</title>
</head>
<body>
<h1>Informe os dados</h1>
<form action="send.php" method="POST">
<p>Name:<input type="text" name="name"></p>
<p>E-mail:<input type="text" name="email"></p>
<p>Phone:<input type="text" name="phone"></p>
<?php
$url = "http://api.pipedrive.com/v1/personFields?api_token=".$TOKEN;
$opts = array(
	"http" => array(
		"method"  => "GET",
		"header"  => "Content-Type: application/json"
	)
);
$context = stream_context_create($opts);
$response = file_get_contents($url, false, $context );
$response = json_decode($response);
//11 is the default number of person fields
if (count($response->data)!=11){
	//For each custom field add in the form
	foreach ($response->data as $data){
		if (strlen($data->key) == 40){
			?>
			<p><?php echo $data->name ?>:<input type="text" name="<?php echo $data->key ?>"></p>
			<?php
		}
	}
}
?>
<input type="submit" value="Submit to Pipedrive">
</form>
</body>
</html>
