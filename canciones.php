<?php
class Cancion extends DB {
    private $id_cancion;
    private $id_user;
    private $id_album;
    private $nombre;
    private $genero;
    private $duracion;
    private $fecha;

	public function setCancnion($id_cancion){
		$query = $this->connect()->prepare('SELECT * FROM playlists WHERE id_cancion = :id');
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

}

?>