<?php

interface AccountStorage {

	public function checkAuth($login, $password);
	public function checkAdmin();
	public function createAcc(Account $acc);
	public function deleteAcc(Account $acc);
}