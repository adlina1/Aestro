<?php

require_once("place.php");

class LieuBuilder{

	 const NAME_REF= 'nom';	
	 const PLACE_REF= 'endroit';
	 const LAT_REF= 'latitude';
	 const LONG_REF = 'longitude';
	 const OWNER = 'owner';

	private $data;
	private $error;

	public function __construct($d){
		$this->data = $d;
		$this->error = $d;
	}

	public function getData(){
		return $this->data;
	}

	public function getError(){
		return $this->error;
	}

	public function createPlace(){
		return new Place($this->data[self::NAME_REF],$this->data[self::PLACE_REF], $this->data[self::LAT_REF], $this->data[self::LONG_REF]);
	}

	public function isValid(){
		$this->error = array();
		if (!key_exists(self::NAME_REF, $this->data) || $this->data[self::NAME_REF] === ""){
			$this->error[self::NAME_REF] = "Vous devez entrer un nom"; }
		if (!key_exists(self::PLACE_REF,$this->data) || $this->data[self::PLACE_REF] === "") {
			$this->error[self::PLACE_REF] = "Vous devez indiquer l'endroit"; }
		if (!key_exists(self::LAT_REF,$this->data) || ($this->data[self::LAT_REF] < -90 || $this->data[self::LAT_REF] > 90)) {
			$this->error[self::LAT_REF] = "Vous devez entrer une coordonnée de latitude entre -90 et 90°"; }
		if(!key_exists(self::LONG_REF,$this->data) || ($this->data[self::LONG_REF] < -180 || $this->data[self::LONG_REF] > 180)) {
			$this->error[self::LONG_REF] = "Vous devez entrer une coordonnée de longtiude entre -180 et 180°"; }
			return count($this->error) == 0;
	}

} // FIN Classe	
