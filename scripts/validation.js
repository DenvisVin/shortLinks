function sendAjax(url, data, method) {
	let responseData = null;
	$.ajax({
		url: url,     
		method: method,
		dataType: 'json',
		data: data,
		async: false,
		success: function(data){
			responseData = data;
		},
		error: function (jqXHR, exception) {
			responseData = false;
		}
	});
	return responseData;
}

$(document).ready(()=>{
	let formInputTextJQ = $('form input[type="text"]'),
		url = 'ajax/validate.php',
		data = {
			'url_validate': 'y'
		},
		errorContainerJQ = $('.error-message');
	
	
	formInputTextJQ.keyup((e) => {
		data['url'] = e.target.value;
		let thisInput = $(this),
			delay = 500,
			method = 'get';

		clearTimeout(thisInput.data('timer'));
		
		thisInput.data('timer', setTimeout(function(){
			
			thisInput.removeData('timer');
			
			let response = sendAjax(url, data, method);
				
			if (!response.data.isUrl) {
				errorContainerJQ.find('.ok').html('');
				errorContainerJQ.find('.error').html('Неправильная ссылка! <br> Проверьте правильность ссылки по инстуркции выше!');
			} else {
				errorContainerJQ.find('.ok').html('Ссылка введена верно! Можно сокращать.');
				errorContainerJQ.find('.error').html('');
			}
			
		}, delay));
	});
});
