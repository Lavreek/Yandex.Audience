<!DOCTYPE html>
<html>
	<head>

		<?php include __DIR__."/assets/layouts/head.php" ?>
		
		<title>Аудитории</title>

		<script type="text/javascript">
			if (document.location.href.indexOf('#') > 0)
				document.location.href = document.location.href.replace("#", "?");
		</script>
		<?php
			if (isset($_GET['access_token']))
			{
				$secret_dir = __DIR__."/.secret/";
				$token_filepath = $secret_dir."token.txt";

				if (!is_dir($secret_dir))
					mkdir($secret_dir);

				if (!file_exists($token_filepath))
					touch($token_filepath);

				file_put_contents($token_filepath, json_encode($_GET));

				echo "<script>document.location.href = '".$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."';</script>";
			}
		?>
	</head>
	<body>

		<div class="container-sm p-5">
			<div class="row justify-content-center p-5">
				<div class="col-md-auto">
					<a class="btn btn-secondary" href="/parse/">Обработать файлы</a>
				</div>
				<div class="col-md-auto" hidden>
					<a class="btn btn-secondary" href="/get-token/"> Получить токен</a>
				</div>
				<div class="col-md-auto">
					<a class="btn btn-secondary" href="/download/">Загрузить файлы в аудиторию</a>
				</div>
			</div>
		</div>

		<?php include __DIR__."/assets/layouts/blockjs.php" ?>
		
	</body>
</html>