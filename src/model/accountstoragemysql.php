<?php 

require_once("model/account.php");
require_once("model/accountstorage.php");
require_once("model/accountbuilder.php");


class AccountStorageMySql implements AccountStorage {

	public $bd;

	public function __construct($pdo){
		$this->bd = $pdo;
	}


	public function checkAuth($login, $password){
		$credentials = "SELECT login, name, password FROM users WHERE BINARY login = ?";
		$stmt = $this->bd->prepare($credentials);
		$res = $stmt->execute([$login]);
		if($res){
			$data = $stmt->fetch();
				if($data == false){ 
					return null; 
				}
			 if(password_verify($password,$data[AccountBuilder::PASS])){
				 return new Account($data[AccountBuilder::NAME_REF],$data[AccountBuilder::LOGIN],$data[AccountBuilder::PASS],$data[AccountBuilder::PASS]);
			} 
		return null;	
		}
	}


	public function createAcc(Account $ac){
		$hash = password_hash($ac->getPassword(), PASSWORD_BCRYPT);
		$new_user = "INSERT INTO `users` (`name`,`login`,`password`) VALUES (?, ?, ?)";
		$stmt = $this->bd->prepare($new_user);
		return $stmt->execute([$ac->getNom(),$ac->getLogin(),$hash]);	
	}


	public function deleteAcc(Account $ac){
		$remove_user = "DELETE FROM `users` WHERE name = ? ";
		$stmt = $this->bd->prepare($remove_user);
		return $stmt->execute([$ac->getNom()]);
	}

	public function checkAdmin(){
		$admin = "SELECT name FROM users WHERE statut = 'admin'";
		$stmt = $this->bd->prepare($admin);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_COLUMN);
	}
	

}