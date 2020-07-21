<?php

include_once 'conexion2.php';


class User extends DB{

	private $id_user;
	private $username;
	private $isartista;
	private $biografia;

	public function setBiografia($id){
		$query = $this->connect()->prepare('SELECT biografia FROM artistas WHERE id_user = :id');
		$query->execute(['id' => $id]);

		foreach ($query as $currentUser) {
			$this->biografia = $currentUser['biografia'];
		}
	}

	public function isArtista($id){
		$query = $this->connect()->prepare('SELECT * FROM  artistas WHERE id_user = :id');
		$query->execute(['id' => $id]);

		if($query->rowCount()){
			$this->isartista = true;
		}else{
			$this->isartista = false;
		}
	}

	public function getIsArtista(){
		return $this->isartista;
	}

	public function userExists($user,$pass){
		$exists;
		$query = $this->connect()->prepare('SELECT * FROM  personas WHERE username = :user AND password = :pass');
		$query->execute(['user' => $user, 'pass' => $pass]);

		if($query->rowCount()){
			return true;
		}else{
			return false;
		}
	}

	public function setUser($user){
		$query = $this->connect()->prepare('SELECT * FROM personas WHERE username = :user');
		$query->execute(['user' => $user]);

		foreach ($query as $currentUser) {
			$this->id_user = $currentUser['id_user'];
			$this->username = $currentUser['username'];
		}
	}

	public function getNombre(){
		return $this->username;
	}

	public function getId(){
		return $this->id_user;
	}

	public function getBiografia(){
		return $this->biografia;
	}

}

?>