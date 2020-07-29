<?php
class Album extends DB {
    private $id_album;
    private $id_user;
    private $nombre;
    private $genero;
    private $duracion;
    private $fecha;
/*
  public function getAlbum(){
    $query = $this->connect()->prepare('SELECT * FROM albumes WHERE id_album = :id');
    $query->execute(['id' => $this->id_album]);

    foreach ($query as $currentUser){
      return $currentUser['nombre'];
    }
    
  }
*/
  public function getCreador(){
    $query = $this->connect()->prepare('SELECT * FROM personas WHERE id_user = :id');
    $query->execute(['id' => $this->id_user]);

    foreach ($query as $currentUser){
      return $currentUser['username'];
    }
    
  }

	public function setAlbum($id_album){
		$query = $this->connect()->prepare('SELECT * FROM albumes WHERE id_album = :id');
		$query->execute(['id' => $id_album]);

		foreach ($query as $currentAlbum){
			$this->id_user = $currentAlbum['id_user'];
			$this->id_album = $currentAlbum['id_album'];
			$this->nombre = $currentAlbum['nombre'];
            $this->genero = $currentAlbum['genero'];
            $this->duracion = $currentAlbum['duracion'];
            $this->fecha = $currentAlbum['fecha'];
		}
    }
    
    public function getId(){
		return $this->id_album;
    }
    
    public function getUser(){
		return $this->id_user;
    }
    
    public function getNombre(){
		return $this->nombre;
    }
    
    public function getGenero(){
		return $this->genero;
    }

    public function getDuracion(){
		return $this->duracion;
    }

    public function getFecha(){
		return $this->fecha;
    }
    

}

?>