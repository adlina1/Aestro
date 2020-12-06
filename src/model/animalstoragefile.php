<?php

//le set est à mettre uniquement au fichier animaux.php 
//et les include se font par rapport au dossier src
// require_once("lib/ObjectFileDB.php");
// require_once("animalstorage.php");


// class AnimalStorageFile implements AnimalStorage {
	
// 	// Contient l'instance de ObjectFileDB. "Enrengistre" la base
// 	public $db;

// 	public function __construct($file){
// 		$this->db = new ObjectFileDB($file);
// 	}
	
// 	public function reinit(){
// 		$this->db->deleteAll();
// 		$this->db->insert(new Animal("Médor","chien",12));
// 		$this->db->insert(new Animal("Félix","chat",11));
// 		$this->db->insert(new Animal("Clochette","chat",18));
//                 $this->db->insert(new Animal("Pouti","cheval",10));
// 	}


// 	 public function read($id){
//                 return $this->db->fetch($id);
// 	}

//         public function readAll(){
//                 return $this->db->fetchAll();
// 	}

// 	public function create(Animal $a){
// 		return $this->db->insert($a);
// 	}

// 	public function delete($id){
// 		if($this->db->exists($id)){
// 			$this->db->delete($id);
// 			return true;
// 		}
// 		return false;
// 	}
	
// }



 

