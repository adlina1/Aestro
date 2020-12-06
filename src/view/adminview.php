<?php

class AdminView extends PrivateView {

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
										<li><a href=".$this->routeur->confirmAccDeletion().">Supprimer mon compte</a></li>"?>
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


    public function showAllImages(array $img){
        $this->title = "Clichés des internautes";
        $this->content = "<h3 id=poste> Ici se trouvent les meilleurs clichés des internautes, bon visionnage! </h3>";
        foreach($img as $key => $value){
            $this->content .= "<table class = 'liste'>";
			$this->content .= "<thead> <div id='banner'> <li> <img id='myImage' src =" .$img[$key]['path']."> </li> </div> </thead>";
			$this->content .= "<tr class=tr> <td> <ul class=button2>";
			$this->content .= '<li><a class="act" href="'.$this->routeur->askDetails($img[$key]['id']).'"> Détails </a></li> '; 	
			$this->content .= '<li><a class="act" href="'.$this->routeur->askModify($img[$key]['id']).'"> Modifier </a></li>';
			$this->content .= '<li><a class ="act" href="'.$this->routeur->getImageAskDeletionURL($img[$key]['id']).'"> Supprimer </a></li>';
			$this->content .= '</ul> </td> </tr>';
			$this->content .= "<tr class=tr> <td> <span class ='txt3'> ".$img[$key]['title']."</span> </td> </tr>";
			$this->content .= "<tr class=tr> <td> <span class ='txt2'> publié par ".$img[$key]['owner']."</span> </td></tr>";
            $this->content .= "</table>";
        }
	}	




	
	
}
