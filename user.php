<?php

include_once 'conexion2.php';
include_once 'playlist.php';


class User extends DB{

	private $id_user;
	private $username;
	private $isartista;
	private $biografia;
	private $playlists;
	private $currPlaylist;

	public function insertUser($username, $pass, $type, $seguidores){
		$query = $this->connect()->prepare('INSERT INTO `personas`(`username`, `password`, `seguidores`) VALUES (:user,:pass,:seguidores)');
		$query->execute(['user' => $username, 'pass' => $pass, 'seguidores' => $seguidores]);

		if($type == "usuario"){
			$datos = $this->connect()->prepare('SELECT * FROM  personas WHERE username = :user AND password = :pass');
			$datos->execute(['user' => $username, 'pass' => $pass]);
			foreach($datos as $newUser){
				$id = $newUser['id_user'];
				$query = $this->connect()->prepare('INSERT INTO `usuarios`(`id_user`) VALUES (:id)');
				$query->execute(['id' => $id]);
			}
		}else{
			$datos = $this->connect()->prepare('SELECT * FROM  personas WHERE username = :user AND password = :pass');
			$datos->execute(['user' => $username, 'pass' => $pass]);
			foreach($datos as $newUser){
				$biografia = "";
				$id = $newUser['id_user'];
				$query = $this->connect()->prepare('INSERT INTO `artistas`(`id_user`, `biografia`) VALUES (:id,:biografia)');
				$query->execute(['id' => $id, 'biografia'=> $biografia]);
			}
		}
	}

	public function setCurrPlaylist($playlist){
		$this->currPlaylist = $playlist;
	}

	public function getCurrPlaylist(){
		return $this->currPlaylist;
	}

	public function getPlaylists(){
		return $this->playlists;
	}

	public function getPlaylistsSeguidas(){
		foreach($this->playlists as $Playlist){
			echo $Playlist->getNombre() . "<br />";
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

	public function registroExists($user){
		$query = $this->connect()->prepare('SELECT * FROM  personas WHERE username = :user');
		$query->execute(['user' => $user]);

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
			$this->playlists = array();
			$this->currPlaylist = new Playlist();
			$this->isartista = false;

			$query = $this->connect()->prepare('SELECT * FROM  artistas WHERE id_user = :id');
			$query->execute(['id' => $currentUser['id_user']]);

			if($query->rowCount()){
				$this->isartista = true;
			}
			
			if($this->isartista){
				$query = $this->connect()->prepare('SELECT biografia FROM artistas WHERE id_user = :id');
				$query->execute(['id' => $this->id_user]);
		
				foreach ($query as $currentUser){
					$this->biografia = $currentUser['biografia'];
				}

			}

			$query = $this->connect()->prepare('SELECT id_playlist FROM personas_playlists WHERE id_user = :id');
			$query->execute(['id' => $this->id_user]);
			
			foreach($query as $currentId){
				$playlist = new Playlist();
				$playlist->setPlaylist($currentId['id_playlist']);
				array_push($this->playlists,$playlist);
			}
		}
	}

	public function setUserId($id){
		$query = $this->connect()->prepare('SELECT * FROM personas WHERE id_user = :id');
		$query->execute(['id' => $id]);

		foreach ($query as $currentUser) {
			$this->id_user = $currentUser['id_user'];
			$this->username = $currentUser['username'];
			$this->playlists = array();
			$this->currPlaylist = new Playlist();
			$this->isartista = false;

			$query = $this->connect()->prepare('SELECT * FROM  artistas WHERE id_user = :id');
			$query->execute(['id' => $currentUser['id_user']]);

			if($query->rowCount()){
				$this->isartista = true;
			}
			
			if($this->isartista){
				$query = $this->connect()->prepare('SELECT biografia FROM artistas WHERE id_user = :id');
				$query->execute(['id' => $this->id_user]);
		
				foreach ($query as $currentUser){
					$this->biografia = $currentUser['biografia'];
				}

			}

			$query = $this->connect()->prepare('SELECT id_playlist FROM personas_playlists WHERE id_user = :id');
			$query->execute(['id' => $this->id_user]);
			
			foreach($query as $currentId){
				$playlist = new Playlist();
				$playlist->setPlaylist($currentId['id_playlist']);
				array_push($this->playlists,$playlist);
			}
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