<?
function print_test($printed)
{
	echo '<pre>';
	print_r($printed);
	echo '</pre>';
}

include 'modules/Connect.php';
include 'modules/UrlValidator.php';

if (isset($_GET['original_link'])) {
	include 'modules/Shorter.php';
	//необходимо передать в конструктор для подключения к БД через PDO:
	//хост*, название БД*, имя пользователя*, пароль*, название таблицы (необязательно)
	$connect = new Connect();
	$userLink = trim($_GET['original_link']);
	if (!UrlValidator::isUrl($userLink)) {
		$errorMessage = 'Неверная ссылка!<br>Проверьте правильность ссылки по инстуркции выше!';
	} else {
		$shorter = new Shorter($connect);
		$shortLink = $shorter->cut($userLink);		
	}
} elseif (
			$_SERVER['REQUEST_URI'] !== '/' && 
			$_SERVER['REQUEST_URI'] !== '' &&
			!preg_match('/\/rest\/\w*/', $_SERVER['REQUEST_URI'])
		 ) {
	include 'modules/Redirect.php';
	
	$connect = new Connect();
	$redirect = new Redirect($connect);
	$short_link = substr($_SERVER['REQUEST_URI'], 1);
	try {
		$redirect->redirectByShortLink($short_link);
	} catch (Exception $e) {
		$errorMessage = $e->getMessage();
	}
} elseif (preg_match('/\/rest\/\w*/', $_SERVER['REQUEST_URI'])) {
	include 'modules/Rest.php';
	include 'modules/Shorter.php';
	
	$connect = new Connect();
	$shorter = new Shorter($connect);
	$rest = new Rest($shorter);
	$rest->getResponse($_SERVER['REQUEST_URI']);
	die();
}
include 'templates/main/index.php';