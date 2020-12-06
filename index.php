<?php

/* On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.*/
set_include_path("./src");
/* Inclusion des classes utilisées dans ce fichier */
require_once("Router.php");
require_once("model/objectstoragemysql.php");
require_once('/users/21809174/private/mysql_config.php');
require_once("model/accountstoragemysql.php");

/* Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main. */
  

$dsn = "mysql:host=".MYSQL_HOST.";port=".MYSQL_PORT.";dbname=".MYSQL_DB.";charset=utf8mb4";

try {
	$bd = new PDO($dsn,MYSQL_USER,MYSQL_PASSWORD);
	$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e){

        echo 'Connection failed: ' . $e->getMessage();
}

$cliplastor = new ObjectStorageMySql($bd);	
$accstor = new AccountStorageMySql($bd);
$authmanager = new AuthentificationManager($accstor);


$router = new Router(); 

$router->main($cliplastor,$accstor,$authmanager); 


?>
