<?php

class View {
	
	protected $title;
	protected $content;
	protected $style;

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
		$this->content = "Test";
	}




}
