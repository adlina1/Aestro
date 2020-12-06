<?php

interface LieuStorage {

	public function read($id);
	public function readAll();
	public function create(Place $a);
	public function modify(Place $a, $id);
	public function delete($id);
	public function ownerOfPlace($id);
}
