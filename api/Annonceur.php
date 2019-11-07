<?php

$fileHandle = fopen("./data/ANNONCEURS.csv", "r");
 
$annonceurs = array();

while (($row = fgetcsv($fileHandle, 0, ";")) !== FALSE) {
	$node = array(); 
	$node["name"] = $row[0];
	$node["description"] = $row[1];

	$address = array();
	$address["contact"] = $row[2];
	$address["firstline"] = $row[3];
	$address["postalCode"] = $row[4];
	$address["city"] = $row[5];
	$node["address"] = $address;

	$node["telephone"] = $row[6];
	$node["portable"] = $row[7];
	$node["mail"] = $row[8];
	$node["webSite"] = $row[9];
	
	$annonceurs[] = $node;
}
	$response = array('success' => true, 'message' => 'Annonceurs loaded', 'annonceurs' => $annonceurs);

    echo json_encode($response);
?>