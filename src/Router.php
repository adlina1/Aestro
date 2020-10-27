<?php

require_once("view/View.php");

class Router {
	

	public function main(){
		
			$view = new View();
			$view->makeHomePage();
			$view->render();


			//$_GET pour switcher entre pages
	}


}
