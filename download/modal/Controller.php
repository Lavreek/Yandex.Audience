<?php
	class Controller extends DownloadHelper
	{
		const download = [
			'queue' => __DIR__."/../../.resources/download/queue/",
			'enemy' => __DIR__."/../../.resources/download/enemy/",
			'complete' => __DIR__."/../../.resources/download/complete/",
		];

		private $replace;

		public function __construct()
		{
			$this->checkControlDirs(self::download);
		}

		public function showDirsFile($tag)
		{
			if (self::download[$tag] !== null)
				$this->showFiles(self::download[$tag]);
		}

		private function showFiles($path)
		{
			$path = array_diff(scandir($path), [".", ".."]);

			if (count($path) > 0)
        	{
	        	foreach ($path as $value)
	        	{
    				include __DIR__."/layouts/files.php";
	        	}
	        }
	        else
	        	echo "<h5 class='lead'>В папке отсутствуют файлы.</h5>";
		}

		public function execPushController($filename)
		{
			require_once __DIR__."/PushControl/PushController.php";

			$control = new PushController();
			$control->pushFile($filename);
		}

		public function moveToComplete($filename)
		{
			rename(self::download['queue'].$filename.".csv", self::download['complete'].$filename.".csv");
			
			$exp = explode(".", $filename);
			$replace = str_replace([',', " ", "(", ")"], "", $exp[0]);

			return json_encode(['file' => $replace, 'original_filename' => $filename, 'message' => 'Загрузка завершена!']);
		}
	}