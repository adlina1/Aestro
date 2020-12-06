<?php

require_once("view/vue.php");
require_once("view/privateview.php");
require_once("view/adminview.php");
require_once("control/controleur.php");
require_once("model/objectstoragemysql.php");
require_once("control/authentificationmanager.php");

	class Router {

		public function main(ObjectStorageMySql $a, AccountStorageMySql $b, AuthentificationManager $c){ 
			
			session_start();

			$feedback = key_exists("feedback", $_SESSION)? $_SESSION["feedback"] : '';
			$_SESSION["feedback"] = '';


			/*************************************************************/
			/********************Affichage public/privé*******************/
			/*************************************************************/

			if(!key_exists('user',$_SESSION)){
				$view = new View($this,$feedback);
			} else {
				$view = new PrivateView($this, $feedback, $_SESSION['user']);
				if($c->isAdminConnected($_SESSION['user'])){
					$view = new AdminView($this, $feedback, $_SESSION['user']);
				}
			}
			
			// var_dump($c->isAdminConnected($_SESSION['user']));
			

			//$ast = new AnimalStorageFile("/users/21809174/tmp/fichier.txt");
			//$ast->reinit();
			$ctrl = new Controlleur($view,$a,$b,$c); 
			
					
			$spotId = key_exists('id', $_GET)? $_GET['id']: null;	
			$action = key_exists('action', $_GET)? $_GET['action']: null;
			

			if($action === null){
			$action = ($spotId === null)? "accueil": "voir";
			} 


			try {

				switch($action){
				case "voir":
					if($spotId === null){
						$view->makeUnknownActionPage();
					} else {
						$ctrl->spotPageId($spotId);
					}
				break; 
				
				case "nouveau":
					$ctrl->newSpot();
				break;

				case "sauverNouveau":
					$ctrl->saveNewSpot($_POST);
				break;

				case "accueil":
					$view->makeHomePage();
				break;

				case "apropos":
					$view->makeAproposPage();
					break;

				case "connexion":
					$view->makeLoginFormPage();
				break;

				case "clicConnexion":
					$ctrl->connection($_POST);
				break;

				case "clicDeconnexion":
					$ctrl->disconnection();
				break;

				case "clicInscription":
					$view->makeRegistrationPage();
				break;

				case "creerCompte":
					$ctrl->createAccount($_POST);
				break;

				case "liste":
					$ctrl->showList();
				break;

				case "lireUn":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$ctrl->spotPageId($spotId); }
				break;

				case "supprimer":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$ctrl->askSpotDeletion($spotId); }	
				break;

				case "confirmerSuppression":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$ctrl->deleteSpot($spotId); }
				break;

				case "modifier":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$ctrl->modifySpot($spotId); }
				break;

				case "sauverModif":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$ctrl->saveSpotModif($spotId,$_POST); }
				break;

				case "supprimerMonCompte":
					$ctrl->saveAccountDeletion();
				break;

				case "confirmerCptSuppression":
					$view->makeAccountDeletionPage();
				break;

				case "voirPageUpload":
					$view->makeImagesUploadPage();
				break;

				case "deposerPhoto":
					$ctrl->uploadPic($_POST);
				break;

				case "listeMesImages":
					$ctrl->listMyImages();
				break;

				case "listeToutesImages":
					$ctrl->listAllImages();
				break;

				case "supprimerImage":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$ctrl->deleteImages($spotId); }
				break;

				case "modifierLimage":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$view->makeImageModifyPage($spotId); }
				break;

				case "confirmerModif":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$ctrl->modifyImages($spotId,$_POST); }
				break;

				case "voirDetails":
					if ($spotId === null) {
						$view->makeUnknownActionPage();
				    } else {
					$ctrl->detailsImage($spotId); }
				break;

				case "rechercher":	
					$ctrl->searchImage($_POST);
				break;

				default:
					$view->makeUnknownActionPage();
					break;
				}	

			} /** end try **/

				catch (Exception $e){
					$view->makeUnexpectedErrorPage($e);
				}
			
		/*	if(!empty($_GET["id"])){
			   $ctrl->showInformation($_GET["id"]);
				} 

			if(isset($_GET["liste"])){
                                $ctrl->showList();
			}*/

			$view->render();

		} // end main
			
			public function POSTredirect($url, $feedback){
				 $_SESSION["feedback"] = $feedback;
				 header("Location: ".htmlspecialchars_decode($url) ,true, 303);
				 die;
			}
			

			// Page d'accueil
			public function homePage(){
				return ".";
			}

			public function aproposPage(){
				return "apropos";
			}

			// ************************************** //
			// ************** SPOTS **************** //
			// ************************************** //

			// Page de création d'un spot (réstreinte aux seuls internautes authentifiés)
			public function getSpotCreationURL(){
				return "nouveau";
			}
			
			// Page d'enrengistrement du spot
			public function getSpotSaveURL(){
				return "sauverNouveau";	
			}
			
			// Page qui demande à l'internaute de confirmer de supprimer le spot
			public function getSpotAskDeletionURL($id){
				return "supprimer?id=$id";				 
			}

			// Page qui supprime le spot
			public function getSpotDeletionURL($id){
				return "confirmerSuppression?id=$id";
			}

			// Modifie un spot
			public function getSpotModifyURL($id){
				return "modifier?id=$id";
			}

			// Confrime la modification d'un spot
			public function updateModifiedSpot($id){
				return "sauverModif?id=$id";
			}
			
			// Page du spot d'id indiqué
			public function spotPageId($spotId) {
   		        return "lireUn?id=$spotId";
			 }

			 // Page de la liste de tous les spots
			public function seeAllSpots(){
				return "liste";
			}


			// ************************************** //
			// ************** ACCOUNT **************** //
			// ************************************** //

			// Page de connexion de l'internaute
			public function connectionPage(){
				return "connexion";
			}
 			
 			// Connexion
			public function signIn(){
				return "clicConnexion";
			}

			// Deconnexion
			public function signOut(){
				return "clicDeconnexion";
			}

			// Inscription
			public function signUp(){
				return "clicInscription";
			}

			// Création du compte effective
			public function registrate(){
				return "creerCompte";
			}

			// Suppression d'un compte courant
			public function deleteMyAcc(){
				return "supprimerMonCompte";
			}

			// Confirme la suppression d'un compte
			public function confirmAccDeletion(){
				return "confirmerCptSuppression";
			}

			// ************************************** //
			// ************** IMAGES **************** //
			// ************************************** //

			// Page d'upload des clichés
			public function uploadPage(){
				return "voirPageUpload";
			}

			// Déposer un ou deux clichés
			public function uploadCliche(){
				return "deposerPhoto";
			}

			// Liste des images d'un utilisateur en particulier
			public function getListMyImages(){
				return "listeMesImages";
			}

			// Liste des clichés de tous les internautes
			public function getListAllImages(){
				return "listeToutesImages";
			}

			// Demander la suppression d'une image
			public function getImageAskDeletionURL($id){
				return "supprimerImage?id=$id";				 
			}

			// Voir les détails d'une image
			public function askDetails($id){
				return "voirDetails?id=$id";
			}

			// Demander la modification d'une image
			public function askModify($id){
				return "modifierLimage?id=$id";
			}

			// Confirmer la modification de l'image
			public function getModification($id){
				return "confirmerModif?id=$id";
			}
		

	} // fin Router

