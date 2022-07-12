<?php
	require_once __DIR__."/../../src/DownloadHelper.php";

	class Controller extends DownloadHelper
	{
		const parse = [
			'queue' => __DIR__."/../../.resources/parse/queue/",
			'complete' => __DIR__."/../../.resources/parse/complete/",
			'process' => __DIR__."/../../.resources/parse/process/",
			'enemy' => __DIR__."/../../.resources/parse/enemy/",
		];

		public function __construct()
		{
			$this->checkControlDirs(self::parse);
		}

		public function execParseController($filename)
		{
			require_once __DIR__."/ParseControl/ParseController.php";

			$control = new ParseController();

			rename(self::parse['queue'].$filename.".xlsx", self::parse['process'].$filename.".xlsx");

			$control->parseConfig(self::parse['process'].$filename.".xlsx", $filename);
		}
	}