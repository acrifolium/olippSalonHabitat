<html>
<head>
  <meta charset="utf-8">
  <title>PHP Test</title>
</head>
<body>

<?php

	require_once('Navigation.php');
	require_once('Authentication.php');

	/*
	 *	Encode array into JSON
	*/
	function json($data){
		if(is_array($data)){
			return json_encode($data);
		}
	}

	$func = AuthenticationFactory::create();
	if(is_null($func))
		echo "Nothing in login";
	else
	{
		$result = $func->RecoverAccount("olivier.azevedo@gmail.com");
		echo json($result);
	}

	// $func = AuthenticationFactory::create();
	// if(is_null($func))
	// 	echo "Nothing in login";
	// else
	// 	echo json($func->IsAdminRegister());

	// $nav = NavigationFactory::create();
	// if(is_null($nav))
	// 	echo "Nothing in Navigation";
	// else
	// 	echo json($nav->GetNavigation());

	// $session = SessionFactory::create();
	// if(is_null($session))
	// 	echo 'session is null';
	// else
	// 	echo json($session->GetSession());

?>

</body>
</html>