<script type="text/javascript">
	<?php
		// echo "window.location.href = 'https://oauth.yandex.ru/authorize?response_type=token&client_id=252d563b1fc24fc78b6256f643ca26ee&redirect_uri=http://localhost'";

		echo "window.location.href = 'https://oauth.yandex.ru/authorize?response_type=token&client_id=252d563b1fc24fc78b6256f643ca26ee&redirect_uri=".$_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."'";
	?>
</script>