<?php
class Cancion extends DB {
    private $id_cancion;
    private $id_user;
    private $id_album;
    private $nombre;
    private $genero;
    private $duracion;
    private $fecha;

  public function getAlbumId(){
    $query = $this->connect()->prepare('SELECT * FROM albumes WHERE id_album = :id');
    $query->execute(['id' => $this->id_album]);

    foreach ($query as $currentUser){
      return $currentUser['id_album'];
    }
    
  }

  public function getAlbum(){
    $query = $this->connect()->prepare('SELECT * FROM albumes WHERE id_album = :id');
    $query->execute(['id' => $this->id_album]);

    foreach ($query as $currentUser){
      return $currentUser['nombre'];
    }
    
  }

  public function getCreador(){
    $query = $this->connect()->prepare('SELECT * FROM personas WHERE id_user = :id');
    $query->execute(['id' => $this->id_user]);

    foreach ($query as $currentUser){
      return $currentUser['username'];
    }
    
  }

	public function setCancion($id_cancion){
		$query = $this->connect()->prepare('SELECT * FROM canciones WHERE id_cancion = :id');
		$query->execute(['id' => $id_cancion]);

		foreach ($query as $currentCancion){
			$this->id_cancion = $currentCancion['id_cancion'];
			$this->id_user = $currentCancion['id_user'];
			$this->id_album = $currentCancion['id_album'];
			$this->nombre = $currentCancion['nombre'];
      $this->genero = $currentCancion['genero'];
      $this->duracion = $currentCancion['duracion'];
      $this->fecha = $currentCancion['fecha'];
		}
    }
    
    public function getId(){
		return $this->id_cancion;
    }
    
    public function getUser(){
		return $this->id_user;
    }
    
    public function getIdAlbum(){
		return $this->id_album;
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