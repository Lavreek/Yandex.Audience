<?php
	require_once __DIR__ . '/ParseControl/SpreadsheetReader.php';  
	require_once __DIR__ . '/ParseControl/Controller.php';    

	$reader = new SpreadsheetReader(__DIR__ . '/target.xlsx');
	$reader->ChangeSheet(0);

	$controller = new Controller();
	$controller->parseExcelTarget($reader);
	
	echo " Обработка завершена! ";
	exit();