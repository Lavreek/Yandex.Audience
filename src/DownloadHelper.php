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

			for ($i = 0; $i < count($names); $i++)
			{
				if ($_SERVER['SERVER_NAME'] == "audition.loc1") 
				{
					copy($tmp_names[$i], $path.mb_convert_encoding($names[$i], "windows-1251", "utf-8"));
				}
				else
				{
					copy($tmp_names[$i], $path.$names[$i]);
				}
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

	        		if ($_SERVER['SERVER_NAME'] == "audition.loc1")
	        		{
	        			$value = mb_convert_encoding($value, "utf-8", "windows-1251");
	        		}

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

		public function showDirsFile($tag, $const_dirs)
		{
			if ($const_dirs[$tag] !== null)
				$this->showFiles($const_dirs[$tag]);
		}

		private function showFiles($path)
		{
			$path = array_diff(scandir($path), [".", ".."]);

			if (count($path) > 0)
        	{
	        	foreach ($path as $value)
	        	{
    				include __DIR__."/../assets/layouts/files.php";
	        	}
	        }
	        else
	        	echo "<h5 class='lead'>В папке отсутствуют файлы.</h5>";
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

		public function moveToComplete($filename, $extens, $path_from, $path_to)
		{
			rename($path_from.$filename.".".$extens, $path_to.$filename.".".$extens);
			
			$replace = str_replace([',', " ", "(", ")"], "", $filename);

			return json_encode(['file' => $replace, 'original_filename' => $filename.".".$extens, 'message' => 'Загрузка завершена!']);
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