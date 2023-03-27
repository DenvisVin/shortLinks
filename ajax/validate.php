<?
if (isset($_GET['url_validate']) &&
	$_GET['url_validate'] === 'y' &&
	isset($_GET['url']) &&
	$_GET['url'] !== ''
	) {
	include $_SERVER['DOCUMENT_ROOT'] . '/modules/UrlValidator.php';
	
	$url = trim($_GET['url']);
	$response = [
		'code' => '200',
		'status' => 'ok',
		'data' => [
			'isUrl' => UrlValidator::isUrl($url)
		]
	];
	
	header('Content-Type: application/json');
	echo json_encode($response);
	die();
}
