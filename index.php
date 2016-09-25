<?php
/* Connection point to the database */
class DBconect{
	private $host = 'localhost';
	private $dbname = 'cfy';
	private $dbuser = 'cfy';
	private $pass = '123';
	static protected $mysql = '';

	public function __construct(){
		try{
			self::$mysql = new PDO( 'mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->dbuser, $this->pass );	
		} catch( PDOException $e ){
			echo 'Подключение не удалось: ' . $e->getMessage();
		}		
	}

	static public function SelectData( $td, $table ){
		$std = self::$mysql->query( 'SELECT' . $td . 'FROM ' . $table );		
	}
}

/* Creating a successor parameters for data output */
class SelectedID extends DBconect{
	static public function SelectData( $td = '*', $table = 'wp_posts' ){
		$std = self::$mysql->query( 'SELECT' . $td . 'FROM ' . $table );
		foreach ( $std as $row ) {
			echo $row['ID'];
		}
	}
}


/*
*
*	
*	BODY
*
*
*/

/* Connection database */
$conect = new DBconect();

/* Output from the database id */
SelectedID::SelectData();