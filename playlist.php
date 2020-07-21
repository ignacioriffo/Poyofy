<?php
include_once 'conexion2.php';

class playlist extends DB{
	private $id_playlist;
	private $id_user;
	private $nombre;
	private $descripcion;
	private $seguidores;

	public function setPlaylist($id_playlist){
		$query = $this->connect()->prepare('SELECT * FROM playlists WHERE id_playlist = :id');
		$query->execute(['id' => $id_playlist]);

		foreach ($query as $currentUser){
			$this->id_user = $currentUser['id_user'];
			$this->nombre = $currentUser['nombre'];
			$this->descripcion = $currentUser['descripcion'];
		}
	}
	
	public function getNombre(){
		return $this->nombre;
	}
}

?>