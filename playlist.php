<?php
include_once 'conexion2.php';
include_once 'cancion.php';

class Playlist extends DB{
	private $id_playlist;
	private $id_user;
	private $nombre;
	private $descripcion;
	private $seguidores;
	private $num_seguidores;
	private $canciones;
	
	public function getCreador(){
		$query = $this->connect()->prepare('SELECT * FROM personas WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);

		foreach ($query as $currentUser){
			return $currentUser['username'];
		}
		
	}

	public function getCanciones(){
		return $this->canciones;
	}

	public function setSeguidores(){
		$query = $this->connect()->prepare('SELECT * FROM personas_playlists WHERE id_playlist = :id');
		$query->execute(['id' => $this->id_playlist]);

		$nseguidores = 0;
		foreach ($query as $currentUser){
			$nseguidores++;
			$seguidor = new User();
			$seguidor->setUserId($currentUser['id_user']);
			array_push($this->seguidores,$seguidor);
		}
		$this->num_seguidores = $nseguidores;
	}

	public function getSeguidores(){
		return $this->seguidores;
	}

	public function getNseguidores(){
		return $this->num_seguidores;
	}

	

	public function setPlaylist($id_playlist){
		$query = $this->connect()->prepare('SELECT * FROM playlists WHERE id_playlist = :id');
		$query->execute(['id' => $id_playlist]);

		foreach ($query as $currentUser){
			$this->id_playlist = $currentUser['id_playlist'];
			$this->id_user = $currentUser['id_user'];
			$this->nombre = $currentUser['nombre'];
			$this->descripcion = $currentUser['descripcion'];
			$this->seguidores = array();
			$this->canciones = array();
		}

		$query = $this->connect()->prepare('SELECT * FROM canciones_playlist WHERE id_playlist = :id');
		$query->execute(['id' => $id_playlist]);

		foreach ($query as $currentCancion){
			$cancion = new Cancion();
			$cancion->setCancion($currentCancion['id_cancion']);
			array_push($this->canciones,$cancion);

		}
	}

	public function getId(){
		return $this->id_playlist;
	}
	
	public function getNombre(){
		return $this->nombre;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

}

?>