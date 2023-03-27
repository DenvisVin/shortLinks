<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Сокращение ссылок</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
<script>
$(document).ready(() => {
	let data = {
		url: 'https://learn.javascript.ru/json'
	};
	$.ajax({
		url: 'http://links/rest/links/?id=9',     
		method: 'DELETE',
		dataType: 'json',
		data: data,
		async: false,
		success: function(data){
			console.log(data);
		},
		error: function (jqXHR, exception, e) {
			console.log(jqXHR);
			console.log(exception);
			console.log(e);
		}
	});
});
</script>
</body>

