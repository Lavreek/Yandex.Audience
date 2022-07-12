<?php
	require_once __DIR__."/../../src/DownloadHelper.php";

	class Controller extends DownloadHelper
	{
		const download = [
			'queue' => __DIR__."/../../.resources/download/queue/",
			'enemy' => __DIR__."/../../.resources/download/enemy/",
			'complete' => __DIR__."/../../.resources/download/complete/",
		];

		public function __construct()
		{
			$this->checkControlDirs(self::download);
		}

		public function execPushController($filename)
		{
			require_once __DIR__."/PushControl/PushController.php";

			$control = new PushController();
			$control->pushFile($filename);
		}
	}