<?php 

class Place{

	private $name;
	private $place;
	private $latitude;
	private $longitude;

	public function __construct($name, $place, $latitude, $longitude){
		$this->name = $name;
		$this->place = $place;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
	}


	public function getNom(){
		return htmlspecialchars($this->name);
	}

	public function getPlace(){
		return htmlspecialchars($this->place);
	}

	public function getLat(){
		return htmlspecialchars($this->latitude);
	}

	public function getLong(){
		return htmlspecialchars($this->longitude);
	}

	public function setNom($n){
		$this->name = htmlspecialchars($n);
	}

	public function setPlace($place){
		$this->place = htmlspecialchars($place);
	}

	public function setLat($lat){
		$this->latitude = htmlspecialchars($lat);
	}

	public function setLong($long){
		$this->longitude = htmlspecialchars($long);
	}
}

