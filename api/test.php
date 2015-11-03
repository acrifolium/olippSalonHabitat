<html>
<head>
  <meta charset="utf-8">
  <title>PHP Test</title>
</head>
<body>

<?php

	require_once('Contact.php');

	/*
	 *	Encode array into JSON
	*/
	function json($data){
		if(is_array($data)){
			return json_encode($data, JSON_UNESCAPED_UNICODE);
		}
	}

	$func = ContactFactory::create();
	if(is_null($func))
		echo "Nothing in dashboard";
	else
	{
		$result = $func->GetContactForm(5);
		echo json($result);
	}

?>

</body>
</html>