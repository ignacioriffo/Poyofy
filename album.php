<?php
class Album extends DB {
    private $id_album;
    private $id_user;
    private $nombre;
    private $genero;
    private $fecha;
    private $canciones;
/*
  public function getAlbum(){
    $query = $this->connect()->prepare('SELECT * FROM albumes WHERE id_album = :id');
    $query->execute(['id' => $this->id_album]);

    foreach ($query as $currentUser){
      return $currentUser['nombre'];
    }
    
  }
*/
	public function añadirCancion($cancionid){
		$query = $this->connect()->prepare('UPDATE `canciones` SET `id_album`= :id WHERE id_cancion = :idc');
		$query->execute(['id' => $this->id_album, 'idc' => $cancionid]);

	}

    public function borrarCancion($cancionid){ //hay q solo modificar campo de albumm a null
        $query = $this->connect()->prepare('UPDATE `canciones` SET `id_album`= NULL WHERE id_cancion = :idc');
        $query->execute(['idc' => $cancionid]);
    }

    public function getCanciones(){
        $this->canciones = array();
        $query = $this->connect()->prepare('SELECT * FROM canciones WHERE id_album = :id');
        $query->execute(['id' => $this->id_album]);

        foreach ($query as $currentCancion){
            $cancion = new Cancion();
            $cancion->setCancion($currentCancion['id_cancion']);
            array_push($this->canciones,$cancion);

        }
        return $this->canciones;
    }

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
            $this->fecha = $currentAlbum['fecha'];
            $this->canciones = array();
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

    public function getFecha(){
		return $this->fecha;
    }
    

}

?>