<?
class Rest
{
	private $shorter;
	private $requestUrl;
	
	public function __construct($shorter)
	{
		$this->shorter = $shorter;
	}
	
	public function getResponse($url)
	{
		$this->requestUrl = $url;
		$this->sendResponse();
	}
	
	private function checkUrl() 
	{
		if (!$this->requestUrl) {
			return false;
		}
		
		$exploded = explode('/rest/', $this->requestUrl);
		$exploded = $exploded[1];
		$afterRest = explode('/', $exploded);
		$afterRest = $afterRest[0];
		
		if ($afterRest !== 'links') {
			return false;
		}
		
		return true;
	}
	
	private function sendResponse()
	{		
		if (!$this->checkUrl()) {
			return false;
		}
		
		$response = [
			'status' => '200',
			'isOk' => true,
			'data' => null
		];
		
		switch($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				$response['data'] = $this->shorter->getList();
				break;
			case 'POST':
				if (empty($_POST['url'])) {
					$response['status'] = '406';
					$response['isOk'] = false;
					$response['error'] = 'Not founded url!';
				} else {
					$userUrl = trim($_POST['url']);
					if (!UrlValidator::isUrl($userUrl)) {
						$response['status'] = '406';
						$response['isOk'] = false;
						$response['error'] = 'Uncorrect data url!';
					} else {
						$shortUrl = $this->shorter->cut($userUrl);
						$data = [
							'id' => $this->shorter->getIdByOriginalLink($userUrl),
							'original_url' => $userUrl,
							'short_url' => $_SERVER['SERVER_NAME'] . '/' . $shortUrl
						];
						$response['status'] = '201';
						$response['data'] = $data;
					}
				}
				break;
			case 'DELETE':
				$parts = parse_url($this->requestUrl)['query'];
				$id = explode('=', $parts)[1];
				$this->shorter->removeById($id);
				$response['message'] = 'deleted';
				break;
		}
		
		header('Content-Type: application/json');
		
		echo json_encode($response);
	}
}