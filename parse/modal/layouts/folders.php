<?php
echo 
	"<div class='card w-100 mb-2 root-".$replace."'>
		<div class='clearfix py-3'>
			<div class='col float-start'>
				<span class='card-text p-2'>$value</span>
			</div>
			<div class='col float-end'>
				<div class='px-5'>
					<input class='".$replace."' value='".$exp[0]."' hidden>
					<svg style='cursor: pointer;' xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-arrow-down-circle path-".$replace."' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z'/></svg>
					<svg style='display: none;' xmlns='http://www.w3.org/2000/svg' width='28' height='28' fill='currentColor' class='bi bi-check-".$replace."' viewBox='0 0 16 16'> <path d='M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z'/> </svg>
				</div>
			</div>
		</div>
	</div>";
?>