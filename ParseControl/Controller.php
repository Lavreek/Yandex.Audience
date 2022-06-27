<?php
	class Controller
	{
		function __construct() { }

		const package_dir = __DIR__."/../parse/";
		const header = "external_id,phone,email,gender,birthdate\n";

		private $arrays = [];
		private $output = [];
		private $count = 1;

		public function filesPutContents(array $keys, array $values)
		{
			foreach($values as $value)
			{
				foreach ($value as $key => $content)
				{
					if ($key > 0)
					{
						if ($content != 0)
						{
							$count = $this->arrays[$key]['count'];
							$path = self::package_dir.$keys[$key]['name'];

							file_put_contents($path, $count.",,".$value[0].",,\n", FILE_APPEND);

							$keys[$key]['count']++;
							$this->arrays[$key]['count']++;

						}
					}
				}
			}
		}

		public function makeFile(array $names)
		{
			if (!is_dir(self::package_dir))
				mkdir(self::package_dir);

			foreach ($names as $value)
			{
				touch(self::package_dir.$value['name']);
				file_put_contents(self::package_dir.$value['name'], self::header);
			}
		}

		public function makeFileContent(array $header_row, array $meta_row)
		{
			$files = [];

			foreach ($header_row as $key => $value)
			{
				if ($key > 0)
				{
					if ($value != "")
						array_push($files, ['id' => $key, 'name' => $value."-".$meta_row[$key].".csv", 'count' => 1]);
					else
						array_push($files, ['id' => $key, 'name' => $meta_row[$key]."-unique.csv", 'count' => 1]);
				}
				else
					array_push($files, ['id' => $key, 'name' => "none" , 'count' => 0]);
			}

			return $files;
		}

		public function parseExcelTarget($reader)
		{
			$time_start = microtime(true);
			echo "Начало обработки: ".date("h:i:s").".\n";


			foreach ($reader as $row => $row_values) {
				if ($row < 2)
				{
					array_push($this->arrays, $row_values);
				}
				
				if ($row == 2)
				{
					$this->arrays = $this->makeFileContent($this->arrays[0], $this->arrays[1]);

					$this->makeFile($this->arrays);
				}
				
				if ($row > 2)
				{
					$this->output += [$row_values[0] => $row_values];
				}
				
				if ($row > 0 && $row % 300 === 0)
				{
					$this->filesPutContents($this->arrays, $this->output);
					
					$time = (microtime(true) - $time_start)/60;
					echo "Прошло: ".(int)$time." минут.\n";

					$this->output = [];
					echo "Обработанно: $row строк.\n";
				}
			}
		}
	}