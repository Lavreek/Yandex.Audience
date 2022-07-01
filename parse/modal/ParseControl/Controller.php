<?php
	date_default_timezone_set("Europe/Moscow");

	class Controller
	{
		const header = "external_id,phone,email,gender,birthdate\n";

		private $package_dir = __DIR__."/../parse";
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

		public function parseExcelTarget($reader)
		{
			$seconds_start = microtime(true);
			$date_start = date("h:i:s");
			echo "Начало обработки: $date_start.\n";

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

						$this->package_dir .= "-".$this->type."/";
						
						$this->arrays = $this->makeFileContent($this->arrays[0], $this->arrays[1]);
						$this->makeFile($this->arrays);
					}

					$this->output += [$row_values[0] => $row_values];
				}
				
				if ($row > 0 && $row % 300 === 0)
				{
					$this->filesPutContents($this->arrays, $this->output);
					
					$time = (microtime(true) - $seconds_start)/60;
					echo "Прошло: ".(int)$time." минут.\n";

					$this->output = [];
					echo "Обработанно: $row строк.\n";
				}
			}

			$this->makeEndFile($date_start, date("h:i:s"));
		}

		private function makeEndFile($start, $end)
		{
			$filename = __DIR__."/../parse_complete.txt";
			if (!file_exists($filename))
				touch($filename);

			file_put_contents($filename, "start: $start, end: $end");
		}
	}