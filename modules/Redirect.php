<?
class Redirect
{
	private $connectObj;
	private $connectPdoObj;
	private $tableName;
	
	public function __construct($connect)
	{
		$this->connectObj = $connect;
		$this->connectPdoObj = $this->connectObj->getConnect();
		$this->tableName = $this->connectObj->getTableName();
	}
	
	private function getOriginalLinkByShort($short_link)
	{
		$query = "SELECT `original_link` FROM `{$this->tableName}` WHERE `short_link`=:link";
		$queryObj = $this->connectPdoObj->prepare($query);
		$queryObj->execute(['link' => $short_link]);
		
		return $queryObj->fetch(PDO::FETCH_ASSOC);
	}
	
	public function redirectByShortLink($short_link)
	{
		$redirectUrl = $this->getOriginalLinkByShort($short_link);
		if ($redirectUrl === false) {
			throw new Exception('Такой короткой ссылки нет в системе!');
		} else {
			$redirectUrl = $redirectUrl['original_link'];
			header("Location: " . $redirectUrl);
			die();
		}
	}
}