<?php

class AccountBuilder{

	const NAME_REF = 'name';
	const LOGIN = 'login';
	const PASS = 'password';
	const CONFIRM = 'confirmpass';

	private $data;
	private $error;

	public function __construct($d){
		$this->data = $d;
		$this->error = $d;
	}

	public function createAnAccount(){
		return new Account(htmlspecialchars($this->data[self::NAME_REF]),htmlspecialchars($this->data[self::LOGIN]),htmlspecialchars($this->data[self::PASS]),htmlspecialchars($this->data[self::CONFIRM]));
	}

	public function isValid(){
		$this->error = array();
		if (!key_exists(self::NAME_REF, $this->data) || $this->data[self::NAME_REF] === ""){
			$this->error[self::NAME_REF] = "Vous devez entrer un nom"; }
		if (!key_exists(self::LOGIN,$this->data) || $this->data[self::LOGIN] === "") {
			$this->error[self::LOGIN] = "Vous devez entrer un login"; }
		if(!key_exists(self::PASS,$this->data) || $this->data[self::PASS] === "") {
			$this->error[self::PASS] = "Vous devez entrer un mot de passe"; }
		if(!key_exists(self::CONFIRM,$this->data) || $this->data[self::CONFIRM] != $this->data[self::PASS]) {
			$this->error[self::CONFIRM] = "Vous devez un mot de passe identique à celui précédemment choisit"; }
			return count($this->error) == 0;
	}

	public function getData(){
		return $this->data;
	}

	public function getError(){
		return $this->error;
	}

}