<?php

	error_reporting(E_ALL);
	set_time_limit(0);

	date_default_timezone_set('Europe/London');


	/** Include path **/
	set_include_path(get_include_path() . PATH_SEPARATOR . './PHPExcel/Classes/');

	/** PHPExcel_IOFactory */
	include 'PHPExcel/IOFactory.php';

	$inputFileName = './data/EXPOSANTS.csv';

	//  Read your Excel workbook
	try {
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	} catch(Exception $e) {
		$response = array('success' => false, 'message' => 'Fichier des exposants invalide');
    	echo json_encode($response);
	    exit;
	}
	
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

	$exposants = array();

	for ($row = 2; $row <= $objPHPExcel->getSheet(0)->getHighestRow(); $row++)
	{
		$node = array(); 
		
		$node["name"] = (string)$sheetData[$row]["C"];
		$node["description"] = (string)$sheetData[$row]["I"];

		$address = array();
		$address["contact"] = (string)$sheetData[$row]["J"];
		$address["firstline"] = (string)$sheetData[$row]["K"];
		$address["postalCode"] = (string)$sheetData[$row]["L"];
		$address["city"] = (string)$sheetData[$row]["M"];
		$node["address"] = $address;

		$node["webSite"] = (string)$sheetData[$row]["Q"];
		$node["telephone"] = (string)$sheetData[$row]["N"];
		$node["portable"] = (string)$sheetData[$row]["O"];
		$node["mail"] = (string)$sheetData[$row]["P"];

		$exposants[] = $node;
	}

	$response = array('success' => true, 'message' => 'Exposants loaded', 'exposants' => $exposants);

    echo json_encode($response);
?>