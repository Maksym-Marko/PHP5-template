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
			?>
			<article>
				<?=$row['ID']?>
			</article>
			<?php
		}
	}
}

/* Print For more information important */
class CreateMenu{
	public $MenuArray = array(
		'Главная' => 'index.php',
		'О нас' => 'about.php',
		'Новости' => 'news.php',
		'Видео' => 'video.php',
		'Контакты' => 'contacts.php',
	);

	public function getMenu(){
		foreach( $this->MenuArray as $nameLink => $link ){
			?>
				<li>
					<a href="<?=$link?>"><?=$nameLink?></a>
				</li>
			<?
		}
	}
}

/* Admin panel */
class AdminPanel{
	static private $login = 'Admin';
	static private $pass = '123';
	static public $infoAutorise = 'Вы не авторизованы';

	static public function Login(){		
		if( isset( $_POST['log'] ) ):
			if( $_POST['login'] == self::$login and $_POST['pass'] == self::$pass ):
				self::$infoAutorise = 'Вы авторизованы';
			else:
				self::$infoAutorise = 'Неправильный логин или пароль!';
			endif;			
		endif;
		?><div><? echo self::$infoAutorise; ?></div><?		
	}

	static public function AminForm(){
		self::Login(); 
		?><form action="" method="post">
			<input type="text" name="login" placeholder="LOGIN" value="" />
			<input type="password" name="pass" placeholder="PASSWORD" value="" />
			<input type="submit" name="log" value="Войти" />
		</form><?
	}	
}

/* Get url page */
class GetUrlPage{
	protected $urlpage;
	public function GetUrlPage(){
		$this->urlpage = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}
}

class CreateLinkPage extends GetUrlPage{
	public function CreateLink(){
		echo '<a href="http://' . $this->urlpage . '">http://' . $this->urlpage . '</a>';
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
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>PHP5</title>
	</head>
	<body>
		<header>
			<nav>
				<ul>
					<?php
					/* Creant menu */
					$CreantMenu = new CreateMenu();
					$CreantMenu->getMenu();
					?>
				</ul>
			</nav>
		</header>

		<section>
			<?php
			/* Output from the database id */
			SelectedID::SelectData();
			?>
		</section>
		<aside>
			<?php
			/* Admin panel */			
			AdminPanel::AminForm();
			?>
		</aside>
		<footer>
			<nav>
				<ul>
					<?php
					/* Creant menu */
					$CreantMenu->getMenu();
					?>
				</ul>
			</nav>
			<div>This page is: <? $geturl = new CreateLinkPage(); $geturl->CreateLink(); ?></div>
		</footer>
	</body>
</html>