<?
class Shorter
{
	private $connectObj;
	private $connectPdoObj;
	private $tableName;
	public $user_link;
	public $shorted_link;
	
	public function __construct($connect)
	{
		$this->connectObj = $connect;
		$this->connectPdoObj = $this->connectObj->getConnect();
		$this->tableName = $this->connectObj->getTableName();
	}
	
	/**
	* Проверяет наличие записи по введенному url в базе данных по этому подключению
	* $originalLink - введенный пользователем url
	*/
	private function issetRowByOriginalLink($originalLink)
	{
		$query = "SELECT * FROM `{$this->tableName}` WHERE `original_link`=:link";
		$queryObj = $this->connectPdoObj->prepare($query);
		$queryObj->execute(['link' => $originalLink]);
		return !!$queryObj->fetch(PDO::FETCH_ASSOC);
	}
	
	private function issetRowByShortLink($shortLink)
	{
		$query = "SELECT * FROM `{$this->tableName}` WHERE `short_link`=:link";
		$queryObj = $this->connectPdoObj->prepare($query);
		$queryObj->execute(['link' => $shortLink]);
		return !!$queryObj->fetch(PDO::FETCH_ASSOC);
	}
	
	private function createShortLink()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < 6; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	private function setRow($original_link, $short_link)
	{
		$query = "INSERT INTO {$this->tableName} SET `original_link`=:originalLink, `short_link`=:shortLink";
		try {
			$queryObj = $this->connectPdoObj->prepare($query);
			$queryObj->execute(['originalLink' => $original_link, 'shortLink' => $short_link]);
			return true;
		} catch (PDOException $e) {
			print "Ошибка добавления записи в базу данных: " . $e->getMessage() . "<br/>";
			return false;
		};
	}
	
	public function cut($originalLink)
	{
		if ($this->issetRowByOriginalLink($originalLink)) {
			$query = "SELECT `short_link` FROM `{$this->tableName}` WHERE `original_link`=:link";
			$queryObj = $this->connectPdoObj->prepare($query);
			$queryObj->execute(['link' => $originalLink]);
			return $queryObj->fetch(PDO::FETCH_ASSOC)['short_link'];
		} else {
			do {
				$shortLink = $this->createShortLink();
			} while ($this->issetRowByShortLink($shortLink));
			$this->setRow($originalLink, $shortLink);
			return $shortLink;
		}
	}
	
	public function getIdByOriginalLink($originalLink)
	{
		if (!$this->issetRowByOriginalLink($originalLink)) {
			return false;
		}
		
		$query = "SELECT `id` FROM `{$this->tableName}` WHERE `original_link`=:link";
		$queryObj = $this->connectPdoObj->prepare($query);
		$queryObj->execute(['link' => $originalLink]);
		return $queryObj->fetch(PDO::FETCH_ASSOC)['id'];
	}
	
	public function removeById($id)
	{
		$query = "DELETE FROM `{$this->tableName}` WHERE `id`=:id";
		$queryObj = $this->connectPdoObj->prepare($query);
		$queryObj->execute(['id' => $id]);
		return true;
	}
	
	public function getList()
	{
		$query = "SELECT * FROM `{$this->tableName}`";
		$queryObj = $this->connectPdoObj->prepare($query);
		$queryObj->execute();
		return $queryObj->fetchAll(PDO::FETCH_ASSOC);
	}
}