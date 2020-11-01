<?php

require_once("model/Connexion.php");

class View {
	
	protected $title;
	protected $content;
	protected $style;
	protected $router;

	public function __construct(Router $router){
		$this->router = $router;
		$this->style = "";
		$this->title = null;
		$this->content = null;
	}

	public function render(){

	   	if ($this->title === null || $this->content === null) {
                 $this->makeUnexpectedErrorPage();
		}
?>
	<!DOCTYPE html>
	<html lang="fr">
	<head>
	        <title><?php echo $this->title; ?></title>
	        <meta charset="UTF-8" />
	        <link rel="stylesheet" href="styles/style.css" />
	        <style>
				<?php echo $this->style; ?>
	        </style>
	</head>

	<body>
		<?php echo $this->content; ?>
	</body>

	</html>

<?php } // render

	public function makeHomePage(){
		$this->title = "Aestro";
		$c = " <div class=header>
			  	<h1>Bienvenue sur Aestro</h1>
			  	<p>Le site de l'astronomie et de l'aéronotique</p>
				</div>
				<div class=signinup>
				<a href=https://dev-21809174.users.info.unicaen.fr/projet-inf5c-2020/?action=authentification> Créer un compte/S'identifier</a></div>";
		$this->content = $c;
	}
	
	public function makeAuthentificationPage(){

		$this->title = "Identification | Aestro";

		$c = '<form action="'.$this->router->authentification().'"method="POST">'."\n";

		$c .= '<div class ="auth"> 
			   <label class = mail> Email : </label> 
			   <input type="text" placeholder="Enter your username" name="username"> </br>

			     <label class = pswd> Password : </label>
			   <input type="password" placeholder="Enter your password" name ="password"> </br>

			   <button type="submit" name="connexion"> Se connecter </button> </form>';

		$this->content = $c;
	}

	public function makeMyAccountPage(){
		$this->title = "Aestro";
		$this->content = "<h1> Authentifcation réussie. </h1>
							<p> Utilisations du site étendue à 100% </p>";
	}

	public function makeUnknownActionPage(){
		$this->title = "Erreur";
		$this->content = "La page demandée n'existe pas. Cliquez sur retour et réessayez autremement.";
	}

	public function makeUnexpectedErrorPage(){
		$this->title = "Erreur";
		$this->content = "Une erreur s'est produite";
	}

}

