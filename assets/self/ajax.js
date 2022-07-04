let pushurl = document.location.protocol + "//" + document.location.host + document.location.pathname + "modal/Request.php";

function successAjax(response)
{
	alert(response);
	window.location.reload();
}

function sendAjaxForm(url, data)
{
    $.ajax({
    	type: "POST",
    	url: url,
    	data: data,
    	cache: false,
		contentType: false,
		processData: false,
		dataType : 'json',

		success: function(response) {
        	successAjax(response);
    	}
 	});
}

$('.btn-push').on('click', function() {

	//var data = $("#PushFiles").serialize();

	var formData = new FormData();

	$.each($("#fileInput")[0].files, function(key, input) 
	{
		if (key < 20)
		{
			formData.append('file[]', input);
			// console.log(formData.getAll('file[]'))
		}
		else
			return true;
	});

	sendAjaxForm(pushurl, formData);	
});

