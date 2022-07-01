<?php
	class DownloadHelper
	{
		const resource = [
			__DIR__."/../.resources/",
			__DIR__."/../.resources/parse/",
			__DIR__."/../.resources/download/"
		];

		public function __construct()
		{
			$this->makeResourcePackage();
		}

		public function downloadFiles($files, $path)
		{
			$names = $files['name'];
			$full_paths = $files['full_path'];
			$types = $files['type'];
			$tmp_names = $files['tmp_name'];
			$errors = $files['error'];
			$sizes = $files['size'];

			for ($i = 0; $i < count($names); $i ++) { 
				copy($tmp_names[$i], $path.$names[$i]);
			}

			return json_encode('Загрузка завершена!');
		}

		public function showQueue($path_from, $path_to, $extens, $layout)
		{
        	$query = array_diff(scandir($path_from), [".", ".."]);

        	if (count($query) > 0)
        	{
	        	foreach ($query as $value)
	        	{
	        		$exp = explode(".", $value);

	        		if (count($exp) == 2)
        			{
    					if ($exp[1] == $extens)
    					{
    						$replace = str_replace([',', " ", "(", ")"], "", $exp[0]);
    						include $layout;
    					}
    					else
    					{
    						rename($path_from.$value, $path_to.$value);
    					}
        			}
	        	}
	        }
	        else
	        	echo "<h5 class='lead'>В очереди пусто.</h5>";
		}

		protected function checkControlDirs($dirs)
		{
			$this->makeResourcePackage();

			foreach ($dirs as $dir)
			{
				if (!is_dir($dir))
					mkdir($dir);
			}
		}

		private function makeResourcePackage()
		{
			foreach (self::resource as $value)
			{
				if (!is_dir($value))
					mkdir($value);	
			}
		}
	}