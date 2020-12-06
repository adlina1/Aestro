<?php

// La classe compte décrit ce qui caractérise l'utilisateur
class Account  {

	private $nom;
	private $login;
	private $password;
	private $confirmpass;
	
	public function __construct($n, $log, $pass, $confirm){
		$this->nom = $n;
		$this->login = $log;
		$this->password = $pass;
		$this->confirmpass = $confirm;
	}

	public function getNom(){
		return htmlspecialchars($this->nom);
	}

	public function getLogin(){
		return htmlspecialchars($this->login);
	}

	public function getPassword(){
		return htmlspecialchars($this->password);
	}

	public function getConfirmPassword(){
		return htmlspecialchars($this->confirmpass);
	}


}