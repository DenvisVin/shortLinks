<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Сокращение ссылок</title>
  <link rel="stylesheet" href="styles/style.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="scripts/validation.js"></script>
</head>
<body>
<div class="container">
	<a href="/">
		<h1>Сокращение ссылки</h1>
	</a>
	<div class="info">
	Ссылка должна содержать протокол передачи данных (http:// или https://), название домена (например yandex.ru).<br> 
	Может содержать www, и адреса страниц на сайте после домена, например (yandex.ru/page/), так же get параметры (например yandex.ru?parameter=true).<br>
	Пример правильной ссылки: 
	<a href="https://www.liveinternet.ru/users/3818405/post135324975" target="_blank">
	https://www.liveinternet.ru/users/3818405/post135324975
	</a>
	</div>
	<form action="" name="short_link" method="GET">
		<input type="text" placeholder="Введите ссылку" name="original_link"
			<?if (isset($_GET['original_link'])):?>
			value="<?=$_GET['original_link'];?>"
			<?endif;?>
		>
		<input type="submit" value="Сократить">
	</form>
	<div class="error-message">
		<div class="ok"></div>
		<div class="error">
		<?if (!empty($errorMessage)):?>
		<?=$errorMessage;?>
		<?endif;?>
		</div>
	</div>
	<?if (!empty($shortLink)):?>
	<div class="short-link">
		Сокращенная ссылка:
		<a href="<?=$shortLink;?>" target="_blank"><?=$_SERVER['SERVER_NAME'] . '/' . $shortLink;?></a>
		<br>
		Введенная ссылка: <br> <?=$userLink;?>
	</div>
	<?endif;?>
</div>
</body>
</html>