<html>
<head>
  <meta charset="utf-8">
  <title>PHP Test</title>
</head>
<body>

<?php

	require_once('Exposant.php');

	/*
	 *	Encode array into JSON
	*/
	function json($data){
		if(is_array($data)){
			return json_encode($data, JSON_UNESCAPED_UNICODE);
		}
	}

	$func = ExposantFactory::create();
	if(is_null($func))
		echo "Nothing in dashboard";
	else
	{
		$result = $func->GetExposant();
		echo json($result);
	}

?>

</body>
</html>