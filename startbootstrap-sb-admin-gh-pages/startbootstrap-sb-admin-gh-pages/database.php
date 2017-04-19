<?php
class Database 
{
	private static $dbName = 'ajcoldwe' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'ajcoldwe';
	private static $dbUserPassword = '549820';
	
	private static $cont  = null;
	
	public function __construct() {
		die('Init function is not allowed');
	}
	
	public static function connect()
	{
	   // One connection through whole application
       if ( null == self::$cont )
       {      
        try 
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);  
        }
        catch(PDOException $e) 
        {
          die($e->getMessage());  
        }
       } 
       return self::$cont;
	}
	
	public static function disconnect()
	{
		self::$cont = null;
	}
	
	public function displayListTableContents()
	{
		$pdo = Database::connect();
		$sql = 'SELECT * FROM customers ORDER BY id DESC';
		foreach ($pdo->query($sql) as $row) {
				echo '<tr>';
				echo '<td>'. $row['name'] . '</td>';
				echo '<td>'. $row['email'] . '</td>';
				echo '<td>'. $row['mobile'] . '</td>';
				echo '<td width=250>';
				echo '<a class="btn" href="read.php?id='.$row['id'].'">Read</a>';
				echo '&nbsp;';
				echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
				echo '&nbsp;';
				echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
				echo '</td>';
				echo '</tr>';
		}
		Database::disconnect();
	}
	
	public function displayListHeading()
	{
		echo '<div class-container><div class=row><h3>PHP CRUD Grid</h3>
		</div><div class=row><p><a class="btn
		btn-success"href=create.php>Create</a><table class="table
		table-bordered table-striped"><thead><tr><th>Name<th>Email
		Address<th>Mobile Number<th>Action<tbody>';
	}
	
	public function importBootstrap()
	{
		echo '<!DOCTYPE html><html lang-en><meta charset=utf-8><link href=https://maxcdn.bootstrapcdn.com/bootstrap/3.3.8/css/bootstrap.min.css rel=stylesheet>
		<script src=https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js></script>';
	}
	
	public function displayListFooting()
	{
		echo '</tbody></table></div></div></body></html>';
	}
}
?>