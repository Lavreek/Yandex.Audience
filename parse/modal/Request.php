<?php
	require_once __DIR__."/Controller.php";

	$control = new Controller();

	if (isset($_FILES['file']))
	{
		echo $control->downloadFiles($_FILES['file'], $control::parse['queue']);
	}
	if (isset($_POST['file']))
	{
		$control->execParseController($_POST['file']);
		echo $control->moveToComplete($_POST['file']);
	}