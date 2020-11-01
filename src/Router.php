<?php

require_once("view/View.php");
// require_once("model/Connexion.php");

class Router {
	

	public function main(){

	$view = new View($this);


	//évaluée à expr2 si expr1 est évalué à TRUE , et expr3 si expr1 est évalué à FALSE . 
	$action = key_exists('action', $_GET)? $_GET['action']: null;

	
	try {
		switch($action) {

			case "accueil":
			case "":
				$view->makeHomePage();
				break;

			case "authentification":
				$view->makeAuthentificationPage();
				break;

			case "myAccount":
				$view->makeMyAccountPage();
				break;

			default:
				$view->makeUnknownActionPage();
				break;
		 }

		} catch(Execption $e){
			echo "zut";
		}
			
			$view->render();
}

	//URL de la page d'Accueil
	public function homePage(){
		return ".";
	}

	//URL de la page d'Authentification
	public function authentification(){
		return ".?action=authentification";
	}

	//URL de la page d'utilisateur authentifié
	public function userPage(){
		return ".?action=myAccount";
	}

}

