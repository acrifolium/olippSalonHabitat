<?php
if (isset($_POST['lastname']) && 
	isset($_POST['firstname']) && 
	isset($_POST['email']) && 
	isset($_POST['subject']) && 
	isset($_POST['message'])) {

	$data = array('success' => true, 'message' => 'email sent');
    echo json_encode($data);
}
else {
	$data = array('success' => false, 'message' => 'email not sent');
    echo json_encode($data);
}

?>

