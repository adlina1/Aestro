<?php

require_once("model/accountstoragemysql.php");

class AuthentificationManager{

	protected $accsql;
	

	public function __construct(AccountStorage $accsql){
		$this->accsql = $accsql; 
	}


	public function verify($data){
		if($data[AccountBuilder::LOGIN] != ''){
			if($data[AccountBuilder::PASS] != '')
				if($this->accsql->checkAuth($data[AccountBuilder::LOGIN],$data[AccountBuilder::PASS]) != null){
					$_SESSION['user'] = $this->accsql->checkAuth($data[AccountBuilder::LOGIN],$data[AccountBuilder::PASS]);
					return true;
			}
			return false;
		}
	}

	// Indique si l'internaute est connecté-e ou non
	public function isUserConnected(){
		if(isset($_SESSION['user'])){
			return true;
		}
		return false;
	}

	public function creationCompte($data){
		if($data->getPassword() == $data->getConfirmPassword()){
			if($this->accsql->createAcc($data)){
				return true;	
			}
			return false;
		}
		return false;
	} 
	

	// Indique si l'internaute est connecté avec le status admin
	public function isAdminConnected($sess){
		if(self::isUserConnected()){
			if($this->accsql->checkAdmin()){
				return in_array($sess->getNom(),$this->accsql->checkAdmin());
			}
		}
	}
	

	// Renvoie le nom de l'internaute connecté, s'il n'est pas connecté on lève une exception. (Prend la session user en paramètre)
	public function getUserName($acc){
		if(!self::isUserConnected()){
			throw new Exception("Impossible d'accéder au nom de l'internaute, il n'est pas connecté.");
		} else {
			return $acc->getNom();
		}
	}

	// Déconnecte l'internaute
	public function disconnectUser(){
		 unset($_SESSION['user']);
	}


}