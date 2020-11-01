<?php
session_start();


	require_once("view/View.php");
	require_once("Router.php");

	$r = new Router();
	$v = new View($r);

		$dsn = "mysql:host=mysql.info.unicaen.fr;port=3306;dbname=21809174_1;charset=utf8mb4";
		$user = "21809174";
		$pswd = "c4Q4jlaqfjytpkFW";
		//hasher les mots de passe
		//sécurité injections..

		/** Connexion aux serveurs mysql de la fac **/
		try {

		$bd = new PDO($dsn,$user,$pswd);
		$bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	     
		} catch (PDOException $e){

			echo 'Connection failed: ' . $e->getMessage();
		}

	/** Clic sur le bouton d'inscription **/
	if(!empty($_POST)){
    	if(isset($_POST["inscription"])){
    		header("Location: https://dev-21809174.users.info.unicaen.fr/projet-inf5c-2020/?action=register");
    	}
    }

    /** Se connecter, vérification des infos dans la BDD **/
    if(!empty($_POST)){
    	if(isset($_POST["username"],$_POST["password"])){

    		$username = $_POST["username"];
		    $pswduser = $_POST["password"];
		   
		  	$req = "SELECT username, password FROM users WHERE BINARY username=:username AND BINARY password=:pswduser";

		    $que = $bd->prepare($req);
		    $que->execute(['username' => $username, 'pswduser' => $pswduser]);
		    $res = $que->fetch();

		    if($res == true){
		    	// $_SESSION["user"] = $_POST["username"];
		    	// echo "hello".$_SESSION["user"];
    			header("Location: https://dev-21809174.users.info.unicaen.fr/projet-inf5c-2020/?action=myAccount");

    		} else {
    			echo "Identifiants incorrects";
    		}
    	}
    }


    //PAGE D'INSCRIPTION
    //public function ...()
    if(!empty($_POST)){
    	if(isset($_POST["usr"],$_POST["psw"],$_POST["repeatpsw"])){
			    $login = $_POST["usr"];
			    $pswduser_i = $_POST["psw"];
			    $confirmpswd = $_POST["repeatpsw"];

			  	if($pswduser_i == $confirmpswd) {

			  		$new_entry = "INSERT INTO `users` (`username`,`password`) VALUES (?,?)";

			  		$bd->prepare($new_entry)->execute([$login,$pswduser_i]);


			  	} else {
			  		echo "Les mot de passe ne sont pas identique";
			  	}
			}
}

?>
