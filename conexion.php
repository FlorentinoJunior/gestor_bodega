
<?php 
class PDOConnect
{
	public $dbPDO;
	private $tableName;

	function __construct()
	{
		$this->checkConn();
	}

	private function checkConn($dbhost="localhost", $dbname="gestion_bodega", $dbuser="root", $dbpass="")
	{
		try{
			$this->dbPDO = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpass);
		}catch(PDOException $e){
			print "Error!: ".$e->getMessage()."<br>"; 
			die(); 
		}
		
	}
}



?>