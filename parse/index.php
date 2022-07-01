<?php
	require_once __DIR__."/../src/DownloadHelper.php";
	require_once __DIR__."/modal/Controller.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include __DIR__."/../assets/layouts/head.php" ?>
		
		<title>Обработка xlsx</title>
	</head>
	<body>
		<div class="container p-5">
			<div>
				<div class="row w-100">
					<div>
						<h5>Загрузка</h5>
					</div>
				</div>
				<div class="row w-100">
					<div class="col col-md-6">
						<div class="row w-100">
							<form action="" method="POST" id="PushFiles" enctype="multipart/form-data">
								<div class="mb-3">
									<label class="form-label" for="fileInput" >Выберите файлы</label>
									<input class="form-control" type="file" id="fileInput" multiple>
									<div class="text-muted mb-3">Максимальное ограничение: <?php echo ini_get("max_file_uploads"); ?> файлов.</div>
									<div class=" text-center">
										<input class="btn btn-primary btn-push" type="button" value="Отправить">
									</div>
								</div>
							</form>
						</div>
						<div class="row w-100 clearfix">
							<div class="py-3 w-100 clearfix">
								<div class="float-start">
									<h4>Очередь файлов для загрузки</h4>
								</div>
								<div class="float-end">
									<button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#QueueCollapse" aria-expanded="false" aria-controls="QueueCollapse">Свернуть/Развернуть</button>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<div class="сollapse show" id="QueueCollapse">
										<?php
											(new Controller())->showQueue();
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col col-md-6 log-blocks" style="border: 1px solid rgba(220, 220, 220, .7); border-radius: 8px 8px 8px 8px;"></div>
				</div>
			</div>
		</div>

		<?php include __DIR__."/../assets/layouts/blockjs.php" ?>
	</body>
</html>