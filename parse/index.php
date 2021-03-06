<?php
	require_once __DIR__."/modal/Controller.php";
	
	$control = new Controller();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include __DIR__."/../assets/layouts/head.php"; ?>
		
		<title>Обработка xlsx</title>
	</head>
	<body>
		<div class="row w-100 clearfix">
			<div class="float-start" style="width: 20%;">
				<?php include __DIR__."/../assets/layouts/sidebars.php"; ?>
			</div>
			<div class="float-end w-75">
				<?php include __DIR__."/../assets/layouts/blockinfo.php"; ?>
				<div class="container p-5">
					<div>
						<div class="row w-100">
							<div>
								<h5>Обработка файлов xlsx</h5>
							</div>
						</div>
						<div class="row w-100">
							<div class="col col-md-6">
								<div class="row w-100">
									<form action="" method="POST" id="PushFiles" enctype="multipart/form-data">
										<div class="mb-3">
											<label class="form-label" for="fileInput" >Выберите файлы</label>
											<input class="form-control" type="file" id="fileInput" multiple>
											<div class="text-muted mb-3">Постарайтесь не называть файлы одинаковым именем.</div>
											<div class="lead mb-3">Максимальное ограничение: <?php echo ini_get("max_file_uploads"); ?> файлов.</div>
											<div class="lead mb-3">Максимальное ограничение размера: <?php echo ini_get("upload_max_filesize"); ?>.</div>
											<div class="lead mb-3">Максимальное ограничение отправки: <?php echo ini_get("post_max_size"); ?>.</div>
											<div class=" text-center">
												<input class="btn btn-primary btn-push" type="button" value="Отправить">
											</div>
										</div>
									</form>
								</div>
								<div class="row w-100 clearfix">
									<div class="py-3 w-100 clearfix">
										<div class="float-start">
											<h4>Очередь файлов</h4>
										</div>
										<div class="float-end">
											<button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#QueueCollapse" aria-expanded="false" aria-controls="QueueCollapse">Свернуть/Развернуть</button>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<div class="сollapse show" id="QueueCollapse">
												<?php
													$control->showQueue($control::parse['queue'], $control::parse['enemy'], "xlsx", __DIR__."/modal/layouts/folders.php");
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="py-3 w-100 clearfix">
									<div class="float-start">
										<h4>В процессе обработки</h4>
									</div>
									<div class="float-end">
										<button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#ProcessCollapse" aria-expanded="false" aria-controls="ProcessCollapse">Свернуть/Развернуть</button>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="сollapse collapse" id="ProcessCollapse">
											<?php
												$control->showDirsFile('process', $control::parse);
											?>
										</div>
									</div>
								</div>
								<div class="py-3 w-100 clearfix">
									<div class="float-start">
										<h4>Завершённые файлы</h4>
									</div>
									<div class="float-end">
										<button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#CompleteCollapse" aria-expanded="false" aria-controls="CompleteCollapse">Свернуть/Развернуть</button>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="сollapse collapse" id="CompleteCollapse">
											<?php
												$control->showDirsFile('complete', $control::parse);
											?>
										</div>
									</div>
								</div>
								<div class="py-3 w-100 clearfix">
									<div class="float-start">
										<h4>Странные файлы</h4>
									</div>
									<div class="float-end">
										<button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#EnemyCollapse" aria-expanded="false" aria-controls="EnemyCollapse">Свернуть/Развернуть</button>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="сollapse collapse" id="EnemyCollapse">
											<?php
												$control->showDirsFile('enemy', $control::parse);
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="col col-md-6 log-blocks" style="border: 1px solid rgba(220, 220, 220, .7); border-radius: 8px 8px 8px 8px;"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php include __DIR__."/../assets/layouts/blockjs.php"; ?>
	</body>
</html>