<?php

	error_reporting(E_ALL);
	set_time_limit(0);

	date_default_timezone_set('Europe/London');


	/** Include path **/
	set_include_path(get_include_path() . PATH_SEPARATOR . './PHPExcel/Classes/');

	/** PHPExcel_IOFactory */
	include 'PHPExcel/IOFactory.php';

	$inputFileName = './data/ANNONCEURS.csv';

	//  Read your Excel workbook
	try {
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	} catch(Exception $e) {
		$response = array('success' => false, 'message' => 'Fichier des annonceurs invalide');
    	echo json_encode($response);
	    exit;
	}

	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

	$annonceurs = array();

	for ($row = 2; $row <= $objPHPExcel->getSheet(0)->getHighestRow(); $row++)
	{
		$node = array(); 
		
		$node["name"] = (string)$sheetData[$row]["C"];
		$node["description"] = (string)$sheetData[$row]["H"];

		$address = array();
		$address["contact"] = (string)$sheetData[$row]["I"];
		$address["firstline"] = (string)$sheetData[$row]["J"];
		$address["postalCode"] = (string)$sheetData[$row]["K"];
		$address["city"] = (string)$sheetData[$row]["L"];
		$node["address"] = $address;

		$node["telephone"] = (string)$sheetData[$row]["M"];
		$node["portable"] = (string)$sheetData[$row]["N"];
		$node["mail"] = (string)$sheetData[$row]["O"];

		$annonceurs[] = $node;
	}

	$response = array('success' => true, 'message' => 'Annonceurs loaded', 'annonceurs' => $annonceurs);

    echo json_encode($response);
?>