<?php 

set_include_path("./src");

require_once("Router.php");
// require_once("model/Connexion.php");
require_once("view/View.php");


		$dsn = "mysql:host=mysql.info.unicaen.fr;port=3306;dbname=21809174_1;charset=utf8";
		$user = "21809174";
		$pswd = 'c4Q4jlaqfjytpkFW';


		try {

		$bd = new PDO($dsn,$user,$pswd);
		$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	     
		} catch (PDOException $e){

			echo 'Connection failed: ' . $e->getMessage();
		}


$router = new Router();
$router->main();

?>
