<?php

	require_once("view/View.php");
	require_once("Router.php");


		$dsn = "mysql:host=mysql.info.unicaen.fr;port=3306;dbname=21809174_1;charset=utf8";
		$user = "21809174";
		$pswd = "c4Q4jlaqfjytpkFW";
		//hasher les mots de passe
		//sécurité injections..
		//sign up mode


		try {

		$bd = new PDO($dsn,$user,$pswd);
		$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	     
		} catch (PDOException $e){

			echo 'Connection failed: ' . $e->getMessage();
		}


    if(!empty($_POST)){
    	if(isset($_POST["username"],$_POST["password"])){
    		$username = $_POST["username"];
		    $pswduser = $_POST["password"];
		   	$conect = $_POST["connexion"];
		   
		  	$req = "SELECT username, password FROM users WHERE username=:username AND password=:pswduser";

		    $que = $bd->prepare($req);
		    $que->execute(['username' => $username, 'pswduser' => $pswduser]);
		    $res = $que->fetch();

		    if($res == true){
    			header("Location: https://dev-21809174.users.info.unicaen.fr/projet-inf5c-2020/?action=myAccount");

    		} else {
    			echo "Identifiants incorrects";
    		}

    	} else {
    		echo "<p> something is not set<p>";
    	}
    }
    
    
    	

	$r = new Router();
	$v = new View($r);




?>
