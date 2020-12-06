<?php

require_once("lieustorage.php");

class ObjectStorageMySql implements LieuStorage{

	public $bd;
	
	public function __construct($pdo){
		$this->bd = $pdo;
	}

	// **********************SPOTS******************** //

	public function read($id){
		$sql = "SELECT * FROM place WHERE id = ?";
		$stmt = $this->bd->prepare($sql);
		$stmt->execute([$id]);
		return $stmt->fetch();
	}

	public function readAll(){
		$sth = $this->bd->prepare("SELECT * FROM place");
		$sth->execute();
		return $sth->fetchAll(); 
	}

	public function create(Place $a){
		$nom_usr = $_SESSION['user']->getNom();
		$new_entry = "INSERT INTO `place` (`nom`,`endroit`,`latitude`, `longitude`,`owner`) VALUES (?,?,?,?,?)";
		$stmt = $this->bd->prepare($new_entry);
		$stmt->execute([$a->getNom(),$a->getPlace(),$a->getLat(),$a->getLong(),$nom_usr]);
		return $this->bd->lastInsertId();
	}

	public function delete($id){
		$sql = "DELETE FROM place WHERE id = ?";
		$stmt = $this->bd->prepare($sql);
		return $stmt->execute([$id]);
	}


	public function ownerOfPlace($id){
		$whois = "SELECT owner FROM place WHERE id = ?";
		$stmt = $this->bd->prepare($whois);
		$stmt->execute([$id]);
		return $stmt->fetch();
	}

	public function modify(Place $a, $id){
		$update = "UPDATE place SET nom=?, endroit=?, latitude=?, longitude=? WHERE id=?";
		$stmt = $this->bd->prepare($update);
		return $stmt->execute([$a->getNom(), $a->getPlace(), $a->getLat(), $a->getLong(), $id]);
	}

	// **********************IMAGES******************** //

	public function ownerOfImage($id){
		$whois = "SELECT owner FROM images WHERE id = ?";
		$stmt = $this->bd->prepare($whois);
		$stmt->execute([$id]);
		return $stmt->fetch();
	}
	

	public function uploadOnFileSys(array $data){
		$name = $_SESSION['user']->getNom(); 
		$req = "INSERT INTO `images` (`path`, `owner`, `title`, `author`, `description`) VALUES (?,?,?,?,?)";
		$stmt = $this->bd->prepare($req); 

		$temp = explode(".","../upload/".$_FILES['firstImage']['name']);
		$newfilename = round(microtime(true)) . '.' . end($temp);
		$temp2 = explode(".","../upload/".$_FILES['secondImage']['name']);
		$newfilename2 = round(microtime(true)*2) . '.' . end($temp2);

		$inp1 = array(htmlspecialchars($data['title']),htmlspecialchars($data['author']),htmlspecialchars($data['description']));
		$inp2 = array(htmlspecialchars($data['title2']),htmlspecialchars($data['author2']),htmlspecialchars($data['description2']));

		if(!array_filter($inp1) && !array_filter($inp2)){
			return false;
		}
		if(!array_filter($inp1)){
			$stmt->execute(["../upload/".$newfilename2,$name,htmlspecialchars($data['title2']),htmlspecialchars($data['author2']),htmlspecialchars($data['description2'])]);
			return move_uploaded_file($_FILES['secondImage']['tmp_name'], "../upload/".$newfilename2);
		}
		if(!array_filter($inp2)){
			$stmt->execute(["../upload/".$newfilename,$name,$data['title'],htmlspecialchars($data['author']),htmlspecialchars($data['description'])]);
			return move_uploaded_file($_FILES['firstImage']['tmp_name'], "../upload/".$newfilename);
		}
		if(array_filter($inp1) && array_filter($inp2)){
			$stmt->execute(["../upload/".$newfilename,$name,htmlspecialchars($data['title']),htmlspecialchars($data['author']),htmlspecialchars($data['description'])]);
			$stmt->execute(["../upload/".$newfilename2,$name,htmlspecialchars($data['title2']),htmlspecialchars($data['author2']),htmlspecialchars($data['description2'])]);
			return move_uploaded_file($_FILES['firstImage']['tmp_name'], "../upload/".$newfilename) &&
			move_uploaded_file($_FILES['secondImage']['tmp_name'], "../upload/".$newfilename2);
		}		
	}

	public function readAnImage($id){
		$sql = "SELECT * FROM images WHERE id = ?";
		$stmt = $this->bd->prepare($sql);
		$stmt->execute([$id]);
		return $stmt->fetch();
	}

	public function readMyImages(){
		$name = $_SESSION['user']->getNom();
		$sql = "SELECT * FROM images WHERE owner = ?";
		$stmt = $this->bd->prepare($sql);
		$stmt->execute([$name]);
		return $stmt->fetchAll();
	}

	public function readAllImages(){
		$sth = $this->bd->prepare("SELECT * FROM images");
		$sth->execute();
		return $sth->fetchAll(); 
	}


	public function modifyTheImages($id, array $data){
		$update = "UPDATE images SET title=?, author=?, description=? WHERE id=?";
		$stmt = $this->bd->prepare($update);
		return $stmt->execute([htmlspecialchars($data['title']),htmlspecialchars($data['author']),htmlspecialchars($data['description']),$id]);
	}

	public function deleteImage($id){
		$sql = "DELETE FROM images WHERE id = ?";
		$stmt = $this->bd->prepare($sql);
		return $stmt->execute([$id]);
	}

	public function searchParticularImage(array $data){
		/**  Utilisation de la fonction concat afin d'utiliser la requête préparée **/
		$sql = "SELECT * FROM images WHERE title LIKE CONCAT( '%',?,'%') OR description LIKE CONCAT( '%',?,'%')";	
		$stmt = $this->bd->prepare($sql);
		$stmt->execute([htmlspecialchars($data['contenu']), htmlspecialchars($data['contenu'])]);
		return $stmt->fetchAll();
		
	}

} // FIN Classe

