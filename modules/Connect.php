<?
class Connect 
{
	private $dbConnection;
	private $host;
	private $dbName;
	private $userName;
	private $pass;
	private $tableName;
	
	public function __construct($host = 'localhost', $dbName = 'links', $userName = 'root', $pass = 'root', $tableName='links')
	{
		$this->host = $host;
		$this->dbName = $dbName;
		$this->userName = $userName;
		$this->pass = $pass;
		$this->tableName = $tableName;
	
		try {
			//подключаемся
			$this->dbConnection = new PDO('mysql:host=' . $host, $userName, $pass);
			//проверяем наличие базы и создаем, если не существует
			if (!$this->dbExists($this->dbConnection, $dbName)) {
				$createDbQuery = "CREATE DATABASE {$dbName}";
				$this->dbConnection->exec($createDbQuery);
			}
			//переподключаемся к созданной|имеющейся базе
			$this->dbConnection = null;
			$this->dbConnection = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $userName, $pass);
			//проверяем наличие таблицы в базе и создаем, если не существует
			if (!$this->tableExists($this->dbConnection, $tableName)) {
				$createTableQuery = "CREATE TABLE {$tableName} (id INTEGER AUTO_INCREMENT PRIMARY KEY, original_link TEXT, short_link VARCHAR(6))";
				$this->dbConnection->exec($createTableQuery);
			}
			
		} catch (PDOException $e) {
			print "Ошибка подлючения: " . $e->getMessage() . "<br/>";
			die();
		};
	}
	
	/**
	* Проверяет наличие базы данных по этому подключению
	* $pdo - экземпляр объекта подключения PDO
	* $dbName - имя базы данных
	* return (true|false)
	*/
	private function dbExists($pdo, $dbName)
	{
		try {
			$result = $pdo->query("SHOW DATABASES LIKE '{$dbName}'")->fetch();
		} catch (Exception $e) {
			return false;
		}
		return !!$result;
	}
	
	/**
	* Проверяет наличие таблицы в базе данных по этому подключению
	* $pdo - экземпляр объекта подключения PDO
	* $tableName - имя таблицы
	* return (true|false)
	*/
	private function tableExists($pdo, $tableName)
	{
		try {
			$result = $pdo->query("SELECT 1 FROM {$tableName} LIMIT 1");
		} catch (Exception $e) {
			return false;
		}
		return !!$result;
	}
	
	public function getConnect()
	{
		return $this->dbConnection;
	}
	
	public function getTableName()
	{
		return $this->tableName;
	}
}