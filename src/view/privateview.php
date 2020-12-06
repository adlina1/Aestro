<?php

/** Vue de l'utilisateur authentifié·e **/

class PrivateView extends View {

	protected $routeur;
	protected $feedback;
	protected $account;

	public function __construct(Router $r, $fdb, Account $acc){
		$this->routeur = $r;
		$this->feedback = $fdb;
		$this->account = $acc;
	}


	public function render(){   ?>
		<!DOCTYPE html>
			<html lang ="fr">

				<head>
				   <title> <?php echo $this->title; ?> </title>
				   <meta charset = "UTF-8" />
				   
				   <link rel = "stylesheet" href = "styles/style_commun.css" />
				   <link rel = "stylesheet" href = "styles/style_page_accueil.css" />
				   <link rel = "stylesheet" href = "styles/style_page_a_propos.css" />	
				   <link rel = "stylesheet" href = "styles/style_page_creation.css" />
				   <link rel = "stylesheet" href = "styles/style_page_inscription.css" />
				   <link rel = "stylesheet" href = "styles/style_page_connexion.css" />	
				   <link rel = "stylesheet" href = "styles/style_page_modif.css" />		   
				   <link rel = "stylesheet" href = "styles/style_page_liste.css" />	
				   <link rel = "stylesheet" href = "styles/style_page_clichpub.css" />
				   <link rel = "stylesheet" href = "styles/style_page_upload.css" />				
				</head>

				<body>
					<header>
						<section>  
                			<?php echo "<a href=".$this->routeur->homePage().">";?>
                    			<img id="logo" src="images/logoo.png" alt="logo"/>
                			</a>
            			</section>

						<nav id="mon_menu">
							<ul>
								<?php foreach($this->getMenu() as $txt => $link){
								echo "<li><a href=\"$link\">$txt</a></li>";} ?>
								<li class ='menuderoulant'> <a href="#"> Menu</a> 
									<ul class='sous'>
										<?php echo	"<li><a href=".$this->routeur->signOut().">Déconnexion</a></li>
										<li><a href=".$this->routeur->aproposPage().">A propos</a></li>
										<li><a href=".$this->routeur->confirmAccDeletion().">Supprimer mon compte</a></li>" ?>
								  	</ul>
								</li>									
							</ul>
						</nav>
						


							<div class="barre">
							<form action= rechercher method='POST'>
							<?php echo '<input id="enter" type="search" name = "contenu"	
								placeholder="Rechercher sur le site…"
								aria-label="Rechercher parmi le contenu du site">
								<button class="research" type = "submit"> Search </button> ' ?>	
							</form>
								
							</div>
					

						<?php if($this->feedback !== "") { ?>
						<div class = "feedback"><?php echo $this->feedback; ?></div><?php } ?>
					</header>

					<main>
						<?php echo $this->content; ?> 
					</main>

					<footer>
							<section>
						
                			<?php echo "<a class ='apro' href=".$this->routeur->aproposPage()."> A propos </a>";?>
							<p>&copy; Copyright 2020-2021</p>
						
							</section>
					</footer>
				</body>
			</html>
	<?php
	} 

	  public function getMenu(){
                return array(
						"Accueil" => $this->routeur->homePage(),
						"Ajouter un nouveau spot" => $this->routeur->getSpotCreationURL(),
						"Voir les spots" => $this->routeur->seeAllSpots(),
						"Upload ton cliché" => $this->routeur->uploadPage(),
						"Clichés publics" => $this->routeur->getListAllImages(),
						"Mes clichés" => $this->routeur->getListMyImages(),		
                );
	}

	public function getMenu2(){
		return array(
			"Déconnexion" => $this->routeur->signOut(),
			"Supprimer mon compte" => $this->routeur->confirmAccDeletion(),
		);
	}
	
	// Fonction de Debug
	public function makeDebugPage($variable){
		$this->title = 'Debug';
		$this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
	}	


	/********************************************************/
	/********************Upload des Images*******************/
	/*******************************************************/


	// Formulaire pour l'Upload des images
	public function makeImagesUploadPage(){
		$this->title = "Upload de clichés";
		$this->content = "<h2 id='poste'>Postez vos meilleurs clichés</h2>";
		$this->content .= "<h4> Vous pouvez envoyer une ou deux photos maximum </h4>";
		$this->content .= "<form enctype='multipart/form-data' action=".$this->routeur->uploadCliche()." method='POST'>

		<div class = 'uploadChamp'>
			
			<div class = 'uploadChamp1'>
				<fieldset>
					<legend class = title>Titre :</legend>
					<input type = 'text' placeholder='Enter the title' name = 'title'> 
				</fieldset>

				<fieldset>
					<legend class = author>Auteur :</legend>
					<input type = 'text' placeholder='Enter the author' name = 'author'> 
				</fieldset>

				<fieldset>
					<legend class = description>Description :</legend>
					<textarea id='input' placeholder=' Write a description' name = 'description' rows='10' cols='31'></textarea>
				</fieldset>
					<label>                            </label>
				<input class=uploader type='file' name='firstImage'/>
			</div>


			<div class = 'uploadChamp2'>
				<fieldset>
					<legend class = title>Titre :</legend>
					<input type = 'text' placeholder='Enter the title' name = 'title2'> 
				</fieldset>

				<fieldset>
 					<legend class = author>Auteur :</legend>
					<input type = 'text' placeholder='Enter the author' name = 'author2'> 
				</fieldset>
				<fieldset>
 					<legend class = description>Description :</legend>
					<textarea id='input' placeholder=' Write a description' name = 'description2' rows='10' cols='31'></textarea>
				</fieldset>
				<label>                                           </label>
				<input class=uploader type='file' name='secondImage'/>
			</div>

		</div>

			<button class = 'valider' type='submit' >Valider</button>
			</form>";
	}

	public function makeImageModifyPage($id){
		$this->title = "Modification d'une image";
		$this->content = "<h2 id=poste>Modifiez votre cliché en remplissant les champs ci-dessous:</h2>";
		$this->content .= '<form action="'.$this->routeur->getModification($id).'" method="POST">'."\n";
		$this->content .= "<div class = 'uploadChamp'>
			
		<div class = 'uploadChamp1bis'>
			<fieldset>
				<legend class = title>Titre :</legend>
				<input type = 'text' placeholder='Enter the title' name = 'title'> 
			</fieldset>

			<fieldset>
				<legend class = author>Auteur :</legend>
				<input type = 'text' placeholder='Enter the author' name = 'author'> 
			</fieldset>

			<fieldset>
				<legend class = description>Description :</legend>
				<textarea id='input' placeholder=' Write a description' name = 'description' rows='10' cols='31'></textarea>
			</fieldset>

			<button class=modifier type='submit'> Modifier </button> 
		</div> </div> </form>";
	}

	public function makeUnknownSpotPage(){
		$this->title = "Image inconnue";
		$this->content = "<h4> Erreur: le spot indiqué est inconnu </h4>";
	} 

	public function showMyImages(array $img){
		$this->title = "Mes images";
		$this->content .= "<h3 id=poste> Visualisez vos clichés </h3>";
			foreach($img as $key => $value){
		$this->content .= '<ul class = "liste" >';
		$this->content .= "<div id='banner'> <li> <img id='myImage' src =" .$img[$key]['path']." > </li> </div>";
		$this->content .= "<li> <ul class=button2>";
		$this->content .= '<li><a class="act" href="'.$this->routeur->askDetails($img[$key]['id']).'"> Détails </a></li> '; 	
		$this->content .= '<li><a class="act" href="'.$this->routeur->askModify($img[$key]['id']).'"> Modifier </a></li>';
		$this->content .= '<li><a class ="act" href="'.$this->routeur->getImageAskDeletionURL($img[$key]['id']).'"> Supprimer </a></li>';
		$this->content .= '</ul> </li>';
		$this->content .= '</ul>';
			}
	}

	public function showAllImages(array $img){
		$this->title = "Clichés des internautes";
		$this->content .= "<h3 id=poste> Ici se trouvent les meilleurs clichés des internautes, bon visionnage! </h3>";
		foreach($img as $key => $value){
			$this->content .= "<table class='liste'>";
			$this->content .= "<thead> <div id='banner'> <ul> <li> <img id='myImage' src =" .$img[$key]['path']."> </li> </ul> </div> </thead>";
			$this->content .= "<td><span class ='txt3'> ".$img[$key]['title']."</span></td>";
			$this->content .= "<td><span class ='txt2'> publié par ".$img[$key]['owner']."</span></td>";
			$this->content .= "<td> <ul class=button2>";
			$this->content .= '<li><a class="actall" href="'.$this->routeur->askDetails($img[$key]['id']).'"> Détails </a>';
			$this->content .= '</ul> </td>';
			$this->content .= "</table>";
		}
	}



	public function showSearchedImages(array $img){
		$this->title = "Recherche de clichés";
		$this->content .= "<h3 id=poste> Voici les clichés correspondants à votre recherche </h3>";
		foreach($img as $key => $value){
			$this->content .= "<table class='liste'>";
			$this->content .= "<thead> <div id='banner'> <li> <img id='myImage' src =" .$img[$key]['path']."> </li> </div> </thead>";
			$this->content .= "<td> <span class ='txt3'> ".$img[$key]['title']."</span> </td>";
			$this->content .= "<td> <span class ='txt2'> publié par ".$img[$key]['owner']."</span> </td>";
			$this->content .= "<td> <ul class=button2>";
			$this->content .= '<li> <a class="actall" href="'.$this->routeur->askDetails($img[$key]['id']).'"> Détails </a>';
			$this->content .= '</ul> </td>';
			$this->content .= "</table>";
		}
	}

	public function getDetails(array $img, $id){
		foreach($img as $key => $value){
			 $this->title = "Page sur ".$img[$key]['title'];
			 if($value[0] == $id){
				 $this->title = "Page sur ".$img[$key]['title'];
				 $this->content = "<p id=details>";
				 $this->content .= "Le titre est : ".$img[$key]['title'].".<br>L'auteur s'appelle ".$img[$key]['author'].
				 ".<br> Description de la photo : ".$img[$key]['description'];
				 $this->content .= '</p>';
			}
		}
	
	}

	public function displayUploadSucceeded(){
		$this->routeur->POSTredirect($this->routeur->uploadPage(), 
		"<span class = 'successupload'> <h3 class=success> Vos photos ont été mises en ligne avec succès.</h3> </span>");
	}

	public function displayUploadFailure(){
		$this->routeur->POSTredirect($this->routeur->uploadPage(), 
		"<span class = 'failureupload'> <h4> Il y a eu un problème lors de l'upload de vos photos.</br> Assurez-vous de bien remplir tous 
		les champs et d'avoir envoyer votre image. </h4> </span>");
	}

	public function displayImageDeletedPage(){
		$this->routeur->POSTredirect($this->routeur->getListMyImages(),"<h4 class = 'success'> Votre image a été supprimée avec succés.</h4>");
	}

	public function displayModifiedImagePage(){
		$this->routeur->POSTredirect($this->routeur->getListMyImages(),"<h4 class = 'success'> Votre image a été modifiée avec succés.</h4>");
	}

	public function displayUnauthorizedImageType(){
		$this->routeur->POSTredirect($this->routeur->uploadPage(),"<h4 class = 'failureupload'> Le format de votre image n'est pas le bon
		</br> Format acceptés : PNG, JPEG, GIF.</h4>");
	}


	/********************************************************/
	/************************Lieux************************/
	/*******************************************************/


	// Formulaire pour la création d'un objet
	public function makePlaceCreationPage(LieuBuilder $a){

		$this->title = "Enrengistrement d'un lieu particulier";

		$f = "<h4> Enrengistrez l'endroit qui vous a paru exceptionnel pour vos clichés afin que d'autres internautes puissent le découvrir! </h4>";

		$f .= "<div id=creation>";

		$f .= '<form action="'.$this->routeur->getSpotSaveURL().'" method="POST">'."\n

			<fieldset>
				<legend>Nom :</legend>
				<input type = 'text' name =".LieuBuilder::NAME_REF." placeholder = 'Enter the name of the place'/>
			</fieldset>
			<fieldset>
				<legend>Pays/Ville :</legend>
				<input type = 'text' name = ".LieuBuilder::PLACE_REF." placeholder ='Enter the place'/>
			</fieldset>
			<fieldset>
				<legend>Latitude :</legend>
				<input type = 'text' name = ".LieuBuilder::LAT_REF." placeholder = 'Enter the latitude'/>
			</fieldset>
			<fieldset>
				<legend>Longitude :</legend>
				<input type = 'text' name = ".LieuBuilder::LONG_REF." placeholder = 'Enter the longitude'/>
			</fieldset>
			</div> 
			<button class='create' type ='submit' name='add'> Créer </button> 
			</form>"; 		

		$this->content = $f;
	}


	// Détails sur un objet
	public function makePlacePage(array $place, $id){
		$this->title = "Page sur " .$place[LieuBuilder::NAME_REF];
		$c = "<p id=phrase>";
		$c .= "L'endroit s'appelle: ".$place[LieuBuilder::NAME_REF]."<br>Pays/Ville: ".$place[LieuBuilder::PLACE_REF].
		"<br>Coordonnées géographiques: (".$place[LieuBuilder::LAT_REF].",".$place[LieuBuilder::LONG_REF].")"; 
		
		$c .= "</p>";
		$c .= "<ul class=sup_mod>\n";
        $c .= '<li> <a href="'.$this->routeur->getSpotAskDeletionURL($id).'"> Supprimer </a> </li>'."\n";
        $c .= '<li> <a href="'.$this->routeur->getSpotModifyURL($id).'"> Modifier </a> </li>'."\n";
        $c .= "</ul>\n";
		$this->content = $c;
		
	}
	
	// Formulaire de modification d'un spot
	public function makePlaceModifPage($id, LieuBuilder $a){

		$this->title = "Modifier le lieu";
		$this->content = "<div id=modification>";
		$this->content .= '<form action="'.$this->routeur->updateModifiedSpot($id).'" method="POST">'."\n";
		$this->content .= "<h2> Modifiez le lieu en remplissant les champs ci-dessous:</h2>
						<fieldset>
							<legend>Nom :</legend>
							<input type = 'text' name =".LieuBuilder::NAME_REF." placeholder = 'Enter the name of the place'> <br>
						</fieldset>
						<fieldset>
							<legend>Pays/Ville :</legend>
							<input type = 'text' name = ".LieuBuilder::PLACE_REF." placeholder ='Enter the place'> <br>
						</fieldset>
						<fieldset>
							<legend>Latitude :</legend>
							<input type = 'text' name = ".LieuBuilder::LAT_REF." placeholder = 'Enter the latitude'> <br>
						</fieldset>
						<fieldset>
							<legend>Longitude :</legend>
							<input type = 'text' name = ".LieuBuilder::LONG_REF." placeholder = 'Enter the longitude'> <br>
						</fieldset> ";

		$this->content .= '</div> <button class=createbis type="submit"> Modifier '."\n";
		$this->content .= '</button> </form>'."\n";
	}


	public function makeSpotDeletionPage($id){
		$this->title = "Suppression du spot";
		$this->content = '<form action="'.$this->routeur->getSpotDeletionURL($id).'" method="POST">'."\n";
		$this->content .= "<button id=confirm_sup> Confirmer </button></form>";
	}

	public function makeSpotDeletedPage(){
		$this->title = "Suppression effectuée";
		$this->content = "<p class=success> Vous avez bien supprimé votre spot. </p>";
	}


	/******************************************************************* */
	public function makeAccountDeletionPage(){
		$this->title = "Suppression de votre compte";
		$this->content = '<form action="'.$this->routeur->deleteMyAcc().'" method="POST">'."\n";
		$this->content .= "<h3 id='poste'> Voulez-vous vraiment supprimer votre compte ? </h3>";
		$this->content .= "<button id='suppression'> Confirmer </button></form>";
	}


	public function makeSpotModifiedPage(){
		$this->routeur->POSTredirect($this->routeur->seeAllSpots(), "<h3 class=success> Les informations relatives à votre spot ont bien été modifiés.</h3>");
	}
	
	public function makeSpotNotModifiedPage($id) {
		$this->routeur->POSTredirect($this->routeur->getSpotModifyURL($id), "<h4> Il semble qu'il y ait des erreurs dans le formulaire. Veuillez réessayer. </h4>");
	}

	public function displaySpotCreationSuccess($id){
		$this->routeur->POSTredirect($this->routeur->spotPageId($id),"<h3 class=success> Votre spot a été créé avec succés. </h3>");
	}

	public function displaySpotCreationFailure(){
		$this->routeur->POSTredirect($this->routeur->getSpotCreationURL(), "<h4> Mince! Il semblerait qu'il y ait des erreurs dans votre formulaire.");
	}

	public function displayAccountDeleted(){
		$this->routeur->POSTredirect($this->routeur->homePage(), "<h2 class=success> La suppression de votre compte a été effectué. Nous espérons vous revoir bientôt ! </h2>");
	}

	public function displayDisconnection(){
		$this->routeur->POSTredirect($this->routeur->homePage(), "<h2 class=success> Vous venez de vous déconnecter. </h2>");
	}

	public function displayUnauthorizedActionUser(){
		$this->routeur->POSTredirect($this->routeur->seeAllSpots(),"<h4> Erreur. Vous n'êtes pas le propriétaire de ce lieu. Vous ne pouvez donc pas le supprimer ou modifier. </h4>");
	}

	public function displayImageNotFound(){
		$this->routeur->POSTredirect($this->routeur->homePage(), "<h2 class =failure>  Il semblerait que nous n'ayons rien trouvé en lien avec votre recherche. </h2>");
	}
	

}
