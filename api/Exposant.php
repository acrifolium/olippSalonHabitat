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

	for ($row = 1; $row <= $objPHPExcel->getSheet(0)->getHighestRow(); $row++)
	{
		$node = array(); 
		
		$node["name"] = (string)$sheetData[$row]["A"];
		$node["description"] = (string)$sheetData[$row]["B"];

		$address = array();
		$address["contact"] = (string)$sheetData[$row]["C"];
		$address["firstline"] = (string)$sheetData[$row]["D"];
		$address["postalCode"] = (string)$sheetData[$row]["E"];
		$address["city"] = (string)$sheetData[$row]["F"];
		$node["address"] = $address;

		$node["webSite"] = (string)$sheetData[$row]["J"];
		$node["telephone"] = (string)$sheetData[$row]["G"];
		$node["portable"] = (string)$sheetData[$row]["H"];
		$node["mail"] = (string)$sheetData[$row]["I"];

		$exposants[] = $node;
	}

	$response = array('success' => true, 'message' => 'Exposants loaded', 'exposants' => $exposants);

    echo json_encode($response);
?>