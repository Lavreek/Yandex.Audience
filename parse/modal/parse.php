<?php
	set_time_limit(9999);
	echo "Максимальное время ожидания: ".ini_get('max_execution_time')."\n<br>"; 

	const target = __DIR__ . '/target.xlsx';

	require_once __DIR__ . '/ParseControl/SpreadsheetReader.php';  
	require_once __DIR__ . '/ParseControl/ParseController.php';

	if (file_exists(target))
	{
		$reader = new SpreadsheetReader(target);
		$reader->ChangeSheet(0);

		$controller = new ParseController();
		$controller->parseConsoleExcelTarget($reader);
		
		echo " Обработка завершена! ";
		exit();	
	}
	throw new Exception("Not file exists: ".target, 404);