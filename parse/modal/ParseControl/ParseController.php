<?php
	set_time_limit(9999);
	error_reporting(0);

	require_once __DIR__ . '/SpreadsheetReader.php';  

	date_default_timezone_set("Europe/Moscow");

	class ParseController
	{
		const header = "external_id,phone,email,gender,birthdate\n";
		const save_dir = __DIR__."/../../../.SaveParse/";

		private $package_dir = self::save_dir;

		private $arrays = [];
		private $output = [];
		private $count = 1;
		private $type;

		const array_example = ['external_id' => "", 'phone' => "", 'email' => "", 'gender' => "", 'birthdate' => ""];

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
							$path = $this->package_dir.$keys[$key]['name'];
							$array = self::array_example;

							$array['external_id'] = $count;
							$array[$this->type] = $value[0];

							file_put_contents($path, implode(",", $array)."\n", FILE_APPEND);

							$keys[$key]['count']++;
							$this->arrays[$key]['count']++;

						}
					}
				}
			}
		}

		public function makeFile(array $names)
		{
			if (!is_dir(self::save_dir))
				mkdir(self::save_dir);

			if (!is_dir($this->package_dir))
				mkdir($this->package_dir);

			foreach ($names as $value)
			{
				touch($this->package_dir.$value['name']);
				file_put_contents($this->package_dir.$value['name'], self::header);
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
						array_push($files, ['id' => $key, 'name' => mb_convert_encoding($value, 'windows-1251', 'utf-8')."-".mb_convert_encoding($meta_row[$key], 'windows-1251', 'utf-8')."-".date("d-m-Y")."-".$this->type.".csv", 'count' => 1]);
					else
						array_push($files, ['id' => $key, 'name' => mb_convert_encoding($meta_row[$key], 'windows-1251', 'utf-8')."-unique-".date("d-m-Y")."-".$this->type.".csv", 'count' => 1]);
				}
				else
					array_push($files, ['id' => $key, 'name' => "none" , 'count' => 0]);
			}

			return $files;
		}

		public function parseConfig($filename, $basename)
		{
			$this->package_dir .= $basename;

			if (file_exists($filename))
			{
				$reader = new SpreadsheetReader($filename);
				$reader->ChangeSheet(0);

				$this->ExcelTarget($reader);
			}
			else
				echo "Файл не существует!";
		}

		private function ExcelTarget($reader)
		{
			$seconds_start = microtime(true);
			$date_start = date("h:i:s");

			foreach ($reader as $row => $row_values) {
				if ($row < 2)
				{
					array_push($this->arrays, $row_values);
				}
				
				if ($row > 1)
				{
					if (is_null($this->type))
					{
						if (is_numeric($row_values[0]))
							$this->type = "phone";
						else
							$this->type = "email";

						$this->package_dir .= "-parse-".$this->type."-".date("d-m-Y h-i-s")."/";
						
						$this->arrays = $this->makeFileContent($this->arrays[0], $this->arrays[1]);
						$this->makeFile($this->arrays);
					}

					$this->output += [$row_values[0] => $row_values];
				}
				
				if ($row > 0 && $row % 300 === 0)
				{
					$this->filesPutContents($this->arrays, $this->output);
					
					$time = (microtime(true) - $seconds_start)/60;
					// echo "Прошло: ".(int)$time." минут.\n";

					$this->output = [];
					// echo "Обработанно: $row строк.\n";
				}
			}

			$this->makeEndFile($date_start, date("h:i:s"));
		}

		private function makeEndFile($start, $end)
		{
			$filename = __DIR__."/../../../.SaveParse/parse_complete.txt";
			if (!file_exists($filename))
				touch($filename);

			file_put_contents($filename, "start: $start, end: $end");
		}
	}