function nodeSuccess(file)
{
	let root = '.root-' + file;
	let success = '.bi-check-' + file;

	$(root).css('background', '#98FB98');
	$(success).css('display', 'block');
}

function showLogs(file, message)
{
	$('.log-blocks').append("<div class='px-5 py-3'><div class='card'> <div class='card-body '> <div class='card-text'>Файл: " + file + ". Результат: " + message + "</div> </div> </div> </div>"); 
}

$('.bi-arrow-down-circle').on('click', function(event)
{
	let classes = event.currentTarget.className;
	let file_class = classes.baseVal.split('path-')[1];
	let file_name = $('.' + file_class).val();

	$('.path-' + file_class).css('display', 'none');

	$.ajax({
    	type: "POST",
    	url: pushurl,
    	data: "file=" + file_name,

		success: function(response) {
			let parse = JSON.parse(response);
			nodeSuccess(parse.file);
			showLogs(parse.original_filename, parse.message);
		}
 	});
});