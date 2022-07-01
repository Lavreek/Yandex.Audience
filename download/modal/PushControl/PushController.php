<?php
	class PushController
	{
		const secret_dir = __DIR__."/../../../.secret/";
		const token_filepath = self::secret_dir."token.txt";

		private $token;

		function __construct()
		{
			if (file_exists(self::token_filepath))
			{
				$file_content = json_decode(file_get_contents(self::token_filepath));
				$this->token = $file_content->access_token;
			}
			else
				$this->makeSecretDir();
		}

		private function makeSecretDir()
		{
			if (!is_dir(self::secret_dir))
				mkdir(self::secret_dir);

			if (!file_exists(self::token_filepath))
				touch(self::token_filepath);

			throw new Exception("Write token to file in path: ".self::token_filepath, 1);
		}

		public function pushFile($filename)
		{
			$filepath = __DIR__."/../../../.resources/download/queue/".$filename.".csv";

			$boundary = uniqid();

	        $filename = basename($filepath);

	        $calls = join(PHP_EOL, explode("\n", file_get_contents($filepath)));

	        $data = "--------------------------$boundary\x0D\x0A";
	        $data .= "Content-Disposition: form-data; name=\"file\"; filename=\"$filename\"\x0D\x0A";
	        $data .= "Content-Type: multipart/form-data;\x0D\x0A\x0D\x0A";
	        $data .= $calls . "\x0A\x0D\x0A";
	        $data .= "--------------------------$boundary--";

	        $headers['Content-Type'] = "multipart/form-data; boundary=------------------------$boundary";

	        $headers['Content-Length'] = strlen($data);

	        $resHeaders = [];

	        foreach ($headers as $key=>$head) {
	            $resHeaders[] = $key . ': ' . $head;
	        }

			$send_response = $this->sendRequest(
				"https://api-audience.yandex.ru/v1/management/segments/upload_csv_file",
				[
					'Content-Type: '.$headers['Content-Type'],
					'Content-Length: '.$headers['Content-Length'],
					"Authorization: OAuth ".$this->token
				],
				$data
			);

			$this->saveResponse("send_segment.log", $send_response);

			$parse = json_decode($send_response);
			$segment_id = $parse->segment->id;

			$save_json = [
				"segment" => [
					"id" => $segment_id,
					"name" => $filename,
					"hashed" => 0,
					"content_type" => "crm"
				]
			];

			$save_response = $this->sendRequest(
				"https://api-audience.yandex.ru/v1/management/segment/$segment_id/confirm",
				[
					'Content-Type: application/json',
					"Authorization: OAuth ".$this->token
				],
				$save_json
			);

			$this->saveResponse("save_segment.log", $save_response);

			return true;
		}

		private function sendRequest($url, $headers, $data)
		{
			$ch = curl_init($url);

			if (is_array($data))
				$data = json_encode($data);

			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// curl_setopt($ch, CURLOPT_HEADER, false);

			$response = curl_exec($ch);

			curl_close($ch);

			return $response;
		}

		private function saveResponse($filename, $response)
		{
			$response_dir = __DIR__."/../../../.SaveResponse/";

			if (!is_dir($response_dir))
				mkdir($response_dir);

			$path = $response_dir.$filename;

			if (!file_exists($path))
				touch($path);

			file_put_contents($path, json_encode($response)."\n|\n", FILE_APPEND);
		}
	}