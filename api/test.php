<html>
<head>
  <meta charset="utf-8">
  <title>PHP Test</title>
</head>
<body>

<?php
//phpinfo();
	require_once('Contact.php');

	/*
	 *	Encode array into JSON
	*/
	function json($data){
		if(is_array($data)){
			return json_encode($data);
		}
	}

$response = array();
	$func = ContactFactory::create();

		$result = $func->SendMail("azevedo", "olivier", "olivier.azevedo@gmail.com", "", "", "testtest");
		if($result['status'] == "success")
			$response = json($result);
		else $response = json($result);

echo $response;

?>

</body>
</html>