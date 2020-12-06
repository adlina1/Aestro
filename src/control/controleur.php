<?php

require_once("view/vue.php");
require_once("model/lieubuilder.php");
require_once("model/accountbuilder.php");
require_once("model/objectstoragemysql.php");
require_once("model/accountstoragemysql.php");
require_once("authentificationmanager.php");



class Controlleur{
	
	protected $view;
	protected $obstorage;
	protected $currentNewPlace; 
	protected $accountstorage;
	protected $authmanage;
	protected $currentUser;
	protected $modifyPlace;
	protected $currentImage;
	
	public function __construct(View $v, ObjectStorageMySql $obstr, AccountStorageMySql $accstr, AuthentificationManager $amanage){
		$this->view = $v;
		$this->obstorage = $obstr;
		$this->accountstorage = $accstr;
		$this->authmanage = $amanage;
		$this->currentNewPlace = key_exists('currentNewPlace', $_SESSION) ? $_SESSION['currentNewPlace'] : new LieuBuilder(array());
		$this->modifyPlace = key_exists('modifyPlace',$_SESSION) ? $_SESSION['modifyPlace'] : array();
		$this->currentUser = key_exists('user', $_SESSION) ? $_SESSION['user'] : new AccountBuilder(array());
		$this->currentImage = key_exists('image', $_SESSION) ? $_SESSION['image'] : array();
	}

	/********************************************************/
	/********************Main Functions *******************/
	/*******************************************************/


	// Page du lieu d'id x
	public function spotPageId($id){
		$place = $this->obstorage->read($id);
		if($place == false){
			$this->view->makeUnknownSpotPage();
		} 
		else {
			if(!$this->authmanage->isUserConnected()){
			$this->view->restrictedPlaceDetails();
			}
			$this->view->makePlacePage($place,$id);
		 }
	}
	
	// Liste des lieux
	public function showList(){	
		$this->view->MakeListPage($this->obstorage->readAll());
	}

	// Créer un nouveau lieu
	public function newSpot(){
		if ($this->currentNewPlace == null){
			$this->currentNewPlace = new LieuBuilder();
		} elseif(isset($_SESSION['user'])){
			$this->view->makePlaceCreationPage($this->currentNewPlace);
		} 
	}

	// Enrengistrer le spot dans la base
	public function saveNewSpot(array $data){
		$this->currentNewPlace = new LieuBuilder($data);

		if(!$this->currentNewPlace->isValid()){
			$_SESSION['currentNewPlace'] = $this->currentNewPlace;
			$this->view->displaySpotCreationFailure();
		} else {
			unset($_SESSION['currentNewPlace']);
			$place = $this->currentNewPlace->createPlace();	
		
	        $placeId = $this->obstorage->create($place);
	        $this->view->displaySpotCreationSuccess($placeId);
    	}
	}
	

	// Cliquer sur le lien supprimer
	public function askSpotDeletion($id){ 
		$owner = $this->obstorage->ownerOfPlace($id)[LieuBuilder::OWNER];
		// si l'utilisateur est propriétaire du spot OU si c'est l'admin, alors il peut le delete, sinon non.
		if($this->currentUser->getNom() == $owner || $this->authmanage->isAdminConnected($_SESSION['user'])) {
			$place = $this->obstorage->read($id);
			if($place === null) {
				$this->view->makeUnknownSpotPage();
			} else {
				$this->view->makeSpotDeletionPage($id);
			}
		} else {
			$this->view->displayUnauthorizedActionUser();
		}
	}

	// Confirmer la suppression avec le bouton
	public function deleteSpot($id){ 
		$confirmation = $this->obstorage->delete($id);
		if( !$confirmation ) {
			$this->view->makeUnknownSpotPage();
		} else {
			$this->view->makeSpotDeletedPage();
		}
	}

	// Cliquer sur le lien modifier
	public function modifySpot($id){
		$owner = $this->obstorage->ownerOfPlace($id)[LieuBuilder::OWNER];
		// si l'utilisateur est propriétaire du spot OU si c'est l'admin, alors il peut l'éditer, sinon non.
		if($this->currentUser->getNom() == $owner || $this->authmanage->isAdminConnected($_SESSION['user'])) {
			if($this->currentNewPlace == null){
				$this->currentNewPlace = new LieuBuilder();
			} elseif(isset($_SESSION['user'])){
				$this->view->makePlaceModifPage($id,$this->currentNewPlace);
			} else {
				$this->view->restrictedAccess();
			}
		} else {
			$this->view->displayUnauthorizedActionUser();
		}
	}

	// Enrengistrer la modification en base
	public function saveSpotModif($id, array $data){
		$ani = new Place($data[LieuBuilder::NAME_REF],$data[LieuBuilder::PLACE_REF],$data[LieuBuilder::LAT_REF],$data[LieuBuilder::LONG_REF]);
		$this->currentNewPlace = new LieuBuilder($data);

		if(!$this->currentNewPlace->isValid()){
			$_SESSION['modifyPlace'] = $this->currentNewPlace;
			$this->view->makeSpotNotModifiedPage($id);
		} 
			$anId = $this->obstorage->modify($ani, $id);
			$this->view->makeSpotModifiedPage();
	}


	/********************************************************/
	/********************Authentification*******************/
	/*******************************************************/

	public function connection(array $data){
		if($this->authmanage->verify($data)){
	 		$this->view->displayConnectionSucceeded($_SESSION['user']);
		}
			$this->view->displayConnectionFailure();
	}


	public function disconnection(){
		$this->authmanage->disconnectUser();
		$this->view->displayDisconnection();
	} 

	/********************************************************/
	/********************Inscription************************/
	/*******************************************************/

	public function createAccount(array $data){
		$this->currentUser = new AccountBuilder($data);

		if($this->authmanage->creationCompte($this->currentUser->createAnAccount())){

			if(!$this->currentUser->isValid()){
				$this->view->displayRegistrationFailure();

			} else {
				 // commenter la ligne juste ci-dessous pour retirer l'auto login après inscription.
				self::connection($data);
				$this->view->displayRegistrationSucceeded($this->currentUser);
			}
		}
		 else {
			$this->view->displayRegistrationFailure();
		}		    
	}

	/********************************************************/
	/*****************Suppression Compte*********************/
	/*******************************************************/


	// confirmer suppresion à implémenter
	public function saveAccountDeletion(){
		$acc = $this->currentUser;
		$this->accountstorage->deleteAcc($acc);
		unset($_SESSION['user']);
		$this->view->displayAccountDeleted();
	}


	/********************************************************/
	/***********************Clichés*************************/
	/*******************************************************/


	public function uploadPic(array $data){
		$file = $_FILES['firstImage']['tmp_name'];
		$file2 = $_FILES['secondImage']['tmp_name'];
		$allowed_types = array (IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);

		// si les on upload deux fichiers dont le type est interdit
		if($file !== '' && $file2 !== ''){
			$detectedType = exif_imagetype($file);
			$detectedType2 = exif_imagetype($file2);
			if(!in_array($detectedType,$allowed_types) || !in_array($detectedType2,$allowed_types)){
				$this->view->displayUnauthorizedImageType();
			}
		}
		if($file === '' || $file2 === ''){ /** A **/

			if($file === '' && $file2 === ''){
				$this->view->displayUploadFailure();
			}
			if($file === ''){
				$detectedType2 = exif_imagetype($file2);
				if ( !in_array($detectedType2, $allowed_types) ) 
					$this->view->displayUnauthorizedImageType();
			}
			if($file2 === ''){
				$detectedType = exif_imagetype($file);
				if ( !in_array($detectedType, $allowed_types) ) 
					$this->view->displayUnauthorizedImageType();
			}
			
		} /** A	**/
				if($this->obstorage->uploadOnFileSys($data)){
					$this->view->displayUploadSucceeded();
				}	
			$this->view->displayUploadFailure();
	}

	// Liste de mes images
	public function listMyImages(){
		// if(empty($this->animalstorage->readMyImages())){
		// 	$this->view->displayZeroImage();
		// }
		$this->view->showMyImages($this->obstorage->readMyImages());
	}

	// Liste des images de tous les utilisateurs
	public function listAllImages(){
		$this->view->showAllImages($this->obstorage->readAllImages());
	}

	// Modification des informations d'une image/cliché
	public function modifyImages($id, array $data){
		$owner = $this->obstorage->ownerOfImage($id)['owner'];
		if($this->currentUser->getNom() == $owner || $this->authmanage->isAdminConnected($_SESSION['user'])) {
			if($this->obstorage->modifyTheImages($id, $data)){
				$this->view->displayModifiedImagePage();
			}
		}
		$this->view->displayUnauthorizedActionUser();
	}

	// Suppression des images
	public function deleteImages($id){
		$image = $this->obstorage->readAnImage($id);
		$owner = $this->obstorage->ownerOfImage($id)['owner'];

		if($this->currentUser->getNom() == $owner || $this->authmanage->isAdminConnected($_SESSION['user'])) {
			// suppresion des infos en bdd
			$confirmation = $this->obstorage->deleteImage($id); 
			//suppression de l'image sur le sys de fichier
			unlink($image['path']); 

			if( !$confirmation ) {
				$this->view->makeUnknownImagePage();
			} else {
				$this->view->displayImageDeletedPage();
			}
		}
		$this->view->displayUnauthorizedActionUser(); 
	}

	// Details des images
	public function detailsImage($id){
		$this->view->getDetails($this->obstorage->readAllImages(),$id);
	}

	public function searchImage(array $data){
		if(!empty($this->obstorage->searchParticularImage($data))){
			$this->view->showSearchedImages($this->obstorage->searchParticularImage($data));
		} else {
			$this->view->displayImageNotFound();
		}
		
	}


} /** FIN Classe **/

















// var_dump($this->accountstorage->checkAuth($login,$password));
// 				var_dump($this->accountstorage->checkAuth($login,$password)->getNom());
// 				var_dump($this->accountstorage->checkAuth($login,$password)->getPassword());
// 				var_dump($acc->getNom());
//			var_dump($this->accountstorage->checkAuth($_POST['username'], $_POST['password']));



// 	public function showInformation($id){
// 		if(!key_exists($id,$this->animalstorage->readAll())){
// 		//	if($this->animalstorage->read($id) == null){
// 			$this->view->makeUnknownAnimalPage();
// 		} 
// 		foreach($this->animalstorage->readAll() as $k => $val){
// 		   if($k == $id){
// 		      $this->view->makeAnimalPage($this->animalstorage->read($id)); 
// 		   }
//  	}
// }  /

//var_dump($_SERVER['TMPDIR']);

/* Ancienne manière de faire
	public function showInformation1($id){
                if(!key_exists($id,$this->animalsTab1)){
                        $this->view->makeUnknownAnimalPage();
                }
                foreach($this->animalsTab1 as $k => $val){
                        if($k == $id){
                           for($i=0;$i<count($k);$i++){
                                 $this->view->makeAnimalPage1($this->animalsTab1[$id][$i],$this->animalsTab1[$id][$i+1]);
                            }
//Controleur:ex2                //$this->view->makeAnimalPage("Médor", "chien");

                	}
                }
	}
	
	
	
	      Ancien tableau
 *      public $animalsTab1 = array(
        'medor' => array('Médor', 'chien'),
        'felix' => array('Félix', 'chat'),
        'denver' => array('Denver', 'dinosaure'), 
 ); */

	

//$v = new View();
//$c = new Controlleur($v);

//var_dump($c->animalsTab2["clochette"]);

/*
foreach($c->animalsTab2 as $k => $val){
	echo $k; // j'accède aux clés
	echo "noms: " .$c->animalsTab2[$k]->getNom(). ' '; //j'accède aux valeurs, la première val ici, le nom.
} */

//echo gettype($c->animalsTab["baboo"]->getAge());
