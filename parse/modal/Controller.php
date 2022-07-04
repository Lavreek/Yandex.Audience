<?php
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

		public function showDirsFile($tag)
		{
			if (self::parse[$tag] !== null)
				$this->showFiles(self::parse[$tag]);
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

		public function execParseController($filename)
		{
			require_once __DIR__."/ParseControl/ParseController.php";

			$control = new ParseController();

			rename(self::parse['queue'].$filename.".xlsx", self::parse['process'].$filename.".xlsx");

			$control->parseConfig(self::parse['process'].$filename.".xlsx", $filename);
		}

		public function moveToComplete($filename)
		{
			rename(self::parse['process'].$filename.".xlsx", self::parse['complete'].$filename.".xlsx");
			
			$exp = explode(".", $filename);
			$replace = str_replace([',', " ", "(", ")"], "", $exp[0]);

			return json_encode(['file' => $replace, 'original_filename' => $filename, 'message' => 'Загрузка завершена!']);
		}
	}