<?php
	require_once __DIR__."/../../src/DownloadHelper.php";
	require_once __DIR__."/Controller.php";

	$control = new Controller();

	if (isset($_FILES['file']))
	{
		echo $control->downloadFiles($_FILES['file'], $control::download['queue']);
	}
	if (isset($_POST['file']))
	{
		$control->execPushController($_POST['file']);
		echo $control->moveToComplete($_POST['file'], "csv", $control::download['queue'], $control::download['complete']);
	}