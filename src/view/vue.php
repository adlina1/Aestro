<?php

require_once("Router.php");
require_once("model/lieubuilder.php");
require_once("model/accountbuilder.php");
require_once("model/account.php");

/** Vue de l'utilisateur non authentifié·e **/

class View {

	protected $routeur;
	protected $title;
	protected $content;
	protected $style;
	protected $feedback;
	
	public function __construct(Router $r, $fdb){
		$this->routeur = $r;
		$this->style = "";
		$this->title = null;
		$this->content = null;
		$this->feedback = $fdb;
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
				   <link rel = "stylesheet" href = "styles/style_page_inscription.css" />
				   <link rel = "stylesheet" href = "styles/style_page_connexion.css" />	
				   <link rel = "stylesheet" href = "styles/style_page_liste.css" />	
				   <link rel = "stylesheet" href = "styles/style_page_clichpub.css" />
				</head>

				<body>
					<header>
						<section>  
                			<ul class="button1">
							<?php foreach($this->getMenu2() as $txt => $link){
			 					echo "<li><a href=\"$link\">$txt</a></li>";	} ?>
							</ul>
                			<?php echo "<a href=".$this->routeur->homePage().">";?>
                    			<img src="images/logoo.png" alt="logo"/>
                			</a>
            			</section>

						<nav id="mon_menu1">
							<ul>
							<?php foreach($this->getMenu() as $txt => $link){
			 					echo "<li><a href=\"$link\">$txt</a></li>";	} ?>
							</ul>
						</nav>

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
	
	
	// Menu limité accessible aux non authentifié·e
	public function getMenu(){
		return array(
				"Accueil" => $this->routeur->homePage(),
				"A propos" => $this->routeur->aproposPage(),
				"Voir les spots" => $this->routeur->seeAllSpots(),
				"Clichés publics" => $this->routeur->getListAllImages(),
		);
}

	public function getMenu2(){
	return array(
		"Inscription" => $this->routeur->signUp(),
		"Connexion" => $this->routeur->connectionPage(),
	);
}


	// Page d'accueil
	public function makeHomePage(){ 
		$this->title = "Aestro";
		$c = ' 
		<section class="header">
		</section>
		<img src="images/2222.jpeg" alt="2222"/>		
		<section id="art1">
			<h3>Qu\'est-ce que l\'astronomie?</h3>
			<figure> <img src="images/astronomie.jpg" alt="saturne-s"/> </figure>
			<p>L\'astronomie est la science qui étudie l\'Univers au-delà de l\'atmosphère terrestre. Son nom vient du grec astron, qui veut dire étoile et nomos, qui veut dire loi. Elle s\'intéresse à des objets et des phénomènes tels que les étoiles, les planètes, les comètes, les galaxies et les propriétés de l\'Univers à grande échelle.</p>
			<p>Plus spécifiquement, elle étudie la formation et l\'évolution de l\'Univers, détermine les propriétés physiques et chimiques des objets célestes qu\'il contient et mesure leurs déplacements. L\'astronomie fournit également des informations essentielles pour vérifier les théories fondamentales de la physique, comme la théorie de la relativité.</p>
		</section>
		<section id="art2">
			<h3>Qu\'est-ce que l\'aéronautique?</h3>
			<figure> <img src="images/aéro4.jpeg" alt="aéro"/> </figure>
			<p>L\'aéronautique inclut les sciences et les technologies ayant pour but de construire et de faire évoluer un aéronef dans l\'atmosphère terrestre.</p>
			<p>Les sciences incluent en particulier l\'aérodynamique, une branche de la mécanique des fluides ; les technologies sont celles qui concernent la construction des aéronefs, leur propulsion ainsi que les servitudes. Les entreprises associées à ces technologies sont dans la catégorie entreprise du secteur aéronautique. Piloter un aéronef permet de le faire évoluer et de pratiquer une activité. Les activités principales sont liées à la composante aérienne des forces armées d\'un pays, le transport aérien commercial ou à la pratique d\'une activité de loisir ou de sport aérien. On y associe les organisations et les compagnies gérant ces activités.</p>
		</section>';
		$this->content = $c;
	}

	public function makeAproposPage(){
		$this->title = "A propos | Aestro";
		$c = "<article class=apropos>
				  <h3>Introduction</h3>
				  <p> Le thème de notre site est l'astrophotographie et dans une moindre mesure la photographie d'avions de tout genre (dedans ou en dehors).
				   Au cours de ce projet nous avons décidés que nos objets principaux seraient les clichés publiés par les internautes.
				  Nous avons quand même tenu à garder certaines fonctionnalités implémentées en TP tel que le formulaire de création d'Animaux
				  réadapté pour que les internautes puissent créer des Lieux, représentants les endroits les plus propices à l'astrophotographie.
				   Nous avons fait le choix en ce qui concerne le design de couleurs assez sombres, représentatives de l'univers spatial 
				  dans lequel nous avons décidé de mettre l'accent plus que l'aéronautique, même si les deux se ressemblent et ont un héritage commun, d'où notre volonté de l'intégrer aussi.</p>
				<h3>Membres et numéro de groupe</h3>
				<p>Les numéros des étudiants ayant réalisé cette page web sont listés ci-dessous
				   et font parties du groupe 3.</p>
					<ul>
						<li>21811312</li>
						<li>21602540</li>
						<li>21812759</li>
						<li>21809174</li> 
					</ul>
					
				<h3>Compléments réalisés</h3>
					<p>  Les 3 compléments réalisés sont : </p>	
					<ul>
						<li> (*) Une recherche d'objets. </li>
						<li> (**) Site responsive  (Avec une taille d'écran minimum de 320px).</li>
						<li> (***) Un objet peut être illustré par zéro, une ou plusieurs images (modifiables) uploadées par le créateur de l'objet. </li>
					</ul>
				<h3>Design, modélisation, code</h3>
				<p> Nous avons proposé deux architectures différentes pour deux fonctionnalités différentes, l'une reprennant les grands axes développés lors de nos TPs (qui est celle de la création des Lieux/citations)
				  et l'autre concernant nos objets principaux c'est à dire les images, toujours en MVC mais impliquant moins de classes intermédiaires, tel que l'animalbuilder initialement implémenté ou 
				  encore l'AuthentificationManager, placé dans le package controleur se plaçant entre le controleur principal et le modèle. En ce qui concerne la barre de recherche, elle concerne nos objets principaux, c'est à dire les clichés des internautes.
				  Enfin, nos images sont placées dans un répertoire upload à la racine de nos serveurs web (www-dev), et les chemins ainsi que les informations relatives aux images sont stockées en BDD.
				</p>
			</article>";
		$this->content = $c;
	} 


	// Liste des objets
	public function makeListPage(array $tab){
		$this->title = "Liste des meilleurs endroits";
		foreach($tab as $key => $value){
			$this->content .= "<article class=liste> <ul> <li> <a href=".$this->routeur->spotPageId($value['id']).">".$tab[$key][LieuBuilder::NAME_REF]." </a> </li></ul> </article>";
		}
	} 

	/********************************************************/
	/***************Gestion de possibles erreurs*************/
	/*******************************************************/

	public function makeUnknownPlacePage(){
		$this->title = "Lieu inconnu";
		$this->content = "<h4>Erreur: le lieu indiqué est inconnu</h4>";
	}

	public function makeUnknownActionPage(){
		$this->title = "Erreur";
		$this->content = "<h4>La page demandée n'existe pas</h4>";
	}
	public function makeUnexpectedErrorPage(Exception $e){
		$this->title = "Erreur";
		$this->content = "<h4>Il semblerait qu'une erreur inattendue s'est produite. Cliquez sur retour ou contactez le service technique.</h4>";
	}

	

	/********************************************************/
	/***************Inscription/Authentification*************/
	/*******************************************************/

	public function makeLoginFormPage(){
		$this->title = "Identification | Aestro";
		$c = '<form action="'.$this->routeur->signIn().'" method="POST">'."\n";

		$c .= "<div class=signin> 

				<fieldset>
 					<legend class=log>Login :</legend>
					<input type=text placeholder='Enter your username' name=".AccountBuilder::LOGIN."> </br>
				</fieldset>
					   
			   	<div class =spacer> </div>
			  
				<fieldset>
 					<legend class = pwsd>Password :</legend>
					<input type=password placeholder='Enter your password' name =".AccountBuilder::PASS."> </br>
				</fieldset>

			</div>

				<div class=spacer> </div>

			   <button id=connect type= submit name= connexion > Se connecter </button> </form>";

		$c .= '<hr class = lineconnect> <form action="'.$this->routeur->signUp().'"method="POST">'."\n";

		$c .= 	"<div class = signup >
				<button class=inscript type = submit name = inscription > S'inscrire </button> </div>";
		$this->content = $c;
	}

	public function makeRegistrationPage(){

		$this->title = "Inscription | Aestro";
		$c = '<form action="'.$this->routeur->registrate().'" method="POST">'."\n"; 
		
		$c .=  "<div class=container>
					<h1>Inscrivez-vous</h1>
					<p>Merci de remplir les informations ci-dessous afin d'effectuer votre inscription.</p> 
				</div>

			    <hr class = lineregister> 

			    <div class = form>
				<fieldset>
 					<legend class ='nom'><b>Nom :</b></legend>
					<input type=text placeholder='Enter your name' name = ".AccountBuilder::NAME_REF.">
				</fieldset>

					<div class='spacer'> </div>

				<fieldset>
					<legend class ='login'><b>Login :</b></legend>
					<input type=text placeholder='Enter your username' name = ".AccountBuilder::LOGIN.">
				</fieldset>

					<div class='spacer'> </div>

				<fieldset>
					<legend class ='pass'><b>Password :</b></legend>
					<input type=password placeholder='Enter password' name = ".AccountBuilder::PASS."> 
				</fieldset>

					<div class='spacer'> </div>

				<fieldset>
					<legend class ='confpass'><b>Confirmez votre mot de passe :</b></legend>
					<input type=password placeholder='Confirm your password' name = ".AccountBuilder::CONFIRM."> </br> </br> 
					
					<button class=regi type = submit name = creerCpt > Créer mon compte </button>

				</fieldset>

					<div class=spacer2> </div>

				</div>";

		$this->content = $c;
	}


	/********************************************************/
	/***********************Images**************************/
	/*******************************************************/


	public function showAllImages(array $img){
		$this->title = "Clichés des internautes";
		$this->content = "<h3 class=pubclich> Ici se trouvent les meilleurs clichés des internautes, bon visionnage! </h3>";
		foreach($img as $key => $value){
			$this->content .= "<ul class =liste>";
			$this->content .= "<div id='banner'> <li> <img id='myImage' src =" .$img[$key]['path']."> </li> </div>";
			$this->content .= "<span class ='txt'> <li>  publié par ".$img[$key]['owner']."</li></span> ";
			$this->content .= "</ul>";
		}
	}


	// Redirections d'URL

	public function displayConnectionSucceeded($sess){
		$this->routeur->POSTredirect($this->routeur->homePage(), "<h2 class=success>  Bonjour ".$sess->getNom().", ravi de te voir parmi nous! </h2>");
	}

	public function displayConnectionFailure(){
		$this->routeur->POSTredirect($this->routeur->connectionPage(),"<h4> Vos identifiants sont incorrects. Réessayez.</h4>");
	}

	public function displayRegistrationFailure(){
		$this->routeur->POSTredirect($this->routeur->signUp(),"<h4> Certaines de vos informations sont incorrectes.");
	}

	public function restrictedPlaceDetails(){
		$this->routeur->POSTredirect($this->routeur->seeAllSpots(), "<h4> Vous devez être connecté pour pouvoir visualiser les détails des lieux que vous souhaitez.</h4>");
	}

	



} // fin de la classe View


?>
