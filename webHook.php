<?php
	require_once("../../../core_functions.php");

	//Get the webhook JSON data
	$json = file_get_contents('php://input');
	
	//Decode the JSON data
    $json = json_decode($json);
	
	
	//Write a file with the QID name. Save the retreived QID's within the application/database
	$myFile = "results/". $json->qid .".xml";
	$fh = fopen($myFile, 'w') or die("can't open file");
	
	//Write the file data
	$result = "<Result>\n";
	$result .= "<qid>";
	$result .= $json->qid;
	$result .= "</qid>\n";
	
	$result .= "<api_key>";
	$result .= $json->api_key;
	$result .= "</api_key>\n";
	
	$result .= "<device_id>";
	$result .= $json->extra;
	$result .= "</device_id>\n";
	
	$result .= "<qid_data>\n";
	
		$result .= "<labels>";
		$result .= $json->qid_data->labels;
		$result .= "</labels>\n";
		
		if($json->qid_data->color !== null){
			$result .= "<color>";
			$result .= $json->qid_data->color;
			$result .= "</color>\n";
		}
	
	$result .= "</qid_data>\n";
	$result .= "</Result>";
	
	fwrite($fh, $result);
	fclose($fh);
	
	
	//Write to database
	$device_id = $json->extra;
	$qid = $json->qid;
	$datafile = $myFile;
	$labels = $json->qid_data->labels;
	$colors = $json->qid_data->color;
	
	//Write data to database to ensure the correct result for each device every time!
?>