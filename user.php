<?php

include_once 'conexion2.php';
include_once 'playlist.php';
include_once 'album.php';


class User extends DB{

	private $id_user;
	private $username;
	private $isartista;
	private $biografia;
	private $playlists;
	private $currPlaylist;
	private $seguidos;

	public function playlistExists($idplaylist){
		$query = $this->connect()->prepare('SELECT * FROM personas_playlists WHERE id_user = :id AND id_playlist = :idp');
		$query->execute(['id' => $this->id_user, 'idp' => $idplaylist]);

		if($query->rowCount()){
			return true;
		}else{
			return false;
		}

	}

	public function seguidoExists($idpersona){
		$query = $this->connect()->prepare('SELECT * FROM personas_personas WHERE id_user = :id AND id_seguidor = :ids');
		$query->execute(['id' => $idpersona, 'ids' => $this->id_user]);

		if($query->rowCount()){
			return true;
		}else{
			return false;
		}

	}

	public function borrarCuenta(){
		$query = $this->connect()->prepare('DELETE FROM `personas` WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);
	}

	public function editarDescripcionPlaylist($descripcion, $idp){
		$query = $this->connect()->prepare('UPDATE `playlists` SET `descripcion`= :descripcion WHERE id_playlist = :id');
		$query->execute(['descripcion' => $descripcion, 'id' => $idp]);
		
	}

	public function editarNombrePlaylist($nombre, $idp){
		$query = $this->connect()->prepare('UPDATE `playlists` SET `nombre`= :playlist WHERE id_playlist = :id');
		$query->execute(['playlist' => $nombre, 'id' => $idp]);
		
	}

	public function editarFechaAlbum($fecha, $ida){
		$query = $this->connect()->prepare('UPDATE `albumes` SET `fecha`= :fecha WHERE id_album = :id');
		$query->execute(['fecha' => $fecha, 'id' => $ida]);
		
	}

	public function editarGeneroAlbum($genero, $ida){
		$query = $this->connect()->prepare('UPDATE `albumes` SET `genero`= :genero WHERE id_album = :id');
		$query->execute(['genero' => $genero, 'id' => $ida]);
		
	}

	public function editarNombreAlbum($nombre, $ida){
		$query = $this->connect()->prepare('UPDATE `albumes` SET `nombre`= :album WHERE id_album = :id');
		$query->execute(['album' => $nombre, 'id' => $ida]);
		
	}

	public function getAlbumesArtista(){
		$query = $this->connect()->prepare('SELECT id_album FROM albumes WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);
		$albumes = array();

		foreach($query as $currentId){
			$album = new Album();
			$album->setAlbum($currentId['id_album']);
			array_push($albumes,$album);
		}
		return $albumes;
	}

	public function crearAlbum($album, $genero, $fecha){
		$query = $this->connect()->prepare('INSERT INTO `albumes`(`id_user`, `nombre`, `genero`, `fecha`) VALUES (:id,:nombre,:genero,:fecha)');
		$query->execute(['id' => $this->id_user, 'nombre' => $album, 'genero' => $genero, 'fecha' => $fecha]);
	}

	public function borrarAlbum($album){
		$query = $this->connect()->prepare('DELETE FROM `albumes` WHERE id_album = :ida');
		$query->execute(['ida' => $album]);
	}


	public function searchSongsArtista($string, $artistaid){
        $query = $string;
        $min_length = 1;
        // you can set minimum length of the query if you want
		if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
			$finallist = array();
            $query = htmlspecialchars($query); 
            // changes characters used in html to their equivalents, for example: < to &gt;
            #$q = $this->query($pdo, $str);
            $q = $this->connect()->prepare("SELECT id_cancion FROM canciones WHERE (nombre LIKE '%".$query."%') AND id_user = :ida");
            $q->execute(['ida' => $artistaid]);

            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
                    array_push($lista, $q->fetchColumn(0));
                    $cont++;
				}
			}else{ // if there is no matching rows do following
                return $lista;
			}
			
			return $lista;
        }
        else{ // if query length is less than minimum
            return [];
        }
    }



	public function getAlbumes(){
		$query = $this->connect()->prepare('SELECT id_album FROM albumes WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);
		$albumes = array();

		foreach($query as $currentId){
			$album = new Album();
			$album->setAlbum($currentId['id_album']);
			array_push($albumes,$album);
		}
		return $albumes;
	}

	public function editarFechaCancion($fecha, $idc){
		$query = $this->connect()->prepare('UPDATE `canciones` SET `fecha`= :fecha WHERE id_cancion = :id');
		$query->execute(['fecha' => $fecha, 'id' => $idc]);
		
	}

	public function editarDuracionCancion($duracion, $idc){
		$query = $this->connect()->prepare('UPDATE `canciones` SET `duracion`= :duracion WHERE id_cancion = :id');
		$query->execute(['duracion' => $duracion, 'id' => $idc]);
		
	}

	public function editarGeneroCancion($genero, $idc){
		$query = $this->connect()->prepare('UPDATE `canciones` SET `genero`= :genero WHERE id_cancion = :id');
		$query->execute(['genero' => $genero, 'id' => $idc]);
		
	  }

	public function editarNombreCancion($nombre, $idc){
		$query = $this->connect()->prepare('UPDATE `canciones` SET `nombre`= :cancion WHERE id_cancion = :id');
		$query->execute(['cancion' => $nombre, 'id' => $idc]);
		
	  }

	public function borrarCancion($cancion){
		$query = $this->connect()->prepare('DELETE FROM `canciones` WHERE id_user = :id AND id_cancion = :idc');
		$query->execute(['id' => $this->id_user, 'idc' => $cancion]);
	}

	public function crearCancion($cancion, $genero, $duracion, $fecha){
		$query = $this->connect()->prepare('INSERT INTO `canciones`(`id_user`, `nombre`, `genero`, `duracion`, `fecha`) VALUES (:id,:nombre,:genero,:duracion,:fecha)');
		$query->execute(['id' => $this->id_user, 'nombre' => $cancion, 'genero' => $genero, 'duracion' => $duracion, 'fecha' => $fecha]);
	}

	public function getCancionesArtista(){
		$query = $this->connect()->prepare('SELECT id_cancion FROM canciones WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);
		$canciones = array();

		foreach($query as $currentId){
			$cancion = new Cancion();
			$cancion->setCancion($currentId['id_cancion']);
			array_push($canciones,$cancion);
		}
		return $canciones;
	}

	public function nomegustaCancion($cancionid){
		$query = $this->connect()->prepare('DELETE FROM `usuarios_canciones` WHERE id_user = :id AND id_cancion = :idc');
		$query->execute(['id' => $this->id_user, 'idc' => $cancionid]);
	}

	public function megustaCancion($cancionid){
		$query = $this->connect()->prepare('SELECT * FROM usuarios_canciones WHERE id_user = :id AND id_cancion = :idc');
		$query->execute(['id' => $this->id_user, 'idc' => $cancionid]);

		foreach($query as $current){
			return;
		}

		$query = $this->connect()->prepare('INSERT INTO `usuarios_canciones`(`id_user`, `id_cancion`) VALUES (:iduser,:idc)');
		$query->execute(['iduser' => $this->id_user, 'idc' => $cancionid]);
	}

	public function getCanciones(){
		$query = $this->connect()->prepare('SELECT id_cancion FROM usuarios_canciones WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);
		$canciones = array();

		foreach($query as $currentId){
			$cancion = new Cancion();
			$cancion->setCancion($currentId['id_cancion']);
			array_push($canciones,$cancion);
		}
		return $canciones;
	}

	public function dejarSeguirPlaylist($playlist){
		$query = $this->connect()->prepare('DELETE FROM `personas_playlists` WHERE id_user = :id AND id_playlist = :idp');
		$query->execute(['id' => $this->id_user, 'idp' => $playlist]);
	}

	public function dejarSeguirUsuario($usuarioid){
		$query = $this->connect()->prepare('DELETE FROM `personas_personas` WHERE id_user = :id AND id_seguidor = :ids');
		$query->execute(['id' => $usuarioid, 'ids' => $this->id_user]);
	}

	public function seguirUsuario($usuarioagregado){
		$query = $this->connect()->prepare('SELECT * FROM personas_personas WHERE id_user = :id AND id_seguidor = :ids');
		$query->execute(['id' => $usuarioagregado, 'ids' => $this->id_user]);

		foreach($query as $current){
			return;
		}

		$query = $this->connect()->prepare('INSERT INTO `personas_personas`(`id_user`, `id_seguidor`) VALUES (:id,:ids)');
		$query->execute(['id' => $usuarioagregado, 'ids' => $this->id_user]);

	}

	public function seguirPlaylist($playlistagregada){
		$query = $this->connect()->prepare('SELECT * FROM personas_playlists WHERE id_user = :id AND id_playlist = :idp');
		$query->execute(['id' => $this->id_user, 'idp' => $playlistagregada]);

		foreach($query as $current){
			return;
		}

		$query = $this->connect()->prepare('INSERT INTO `personas_playlists`(`id_user`, `id_playlist`) VALUES (:iduser,:idplaylist)');
		$query->execute(['iduser' => $this->id_user, 'idplaylist' => $playlistagregada]);

	}

	public function searchSongs($string){
        $query = $string;
        $min_length = 1;
        // you can set minimum length of the query if you want
		if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
			$finallist = array();
            $query = htmlspecialchars($query); 
            // changes characters used in html to their equivalents, for example: < to &gt;
            $str = "SELECT id_cancion FROM canciones WHERE (nombre LIKE '%".$query."%')";
            #$q = $this->query($pdo, $str);
            $q = $this->connect()->prepare($str);
            $q->execute();

            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
                    array_push($lista, $q->fetchColumn(0));
                    $cont++;
				}
				array_push($finallist, $lista);
			}else{ // if there is no matching rows do following
                array_push($finallist, []);
            }

            $str = "SELECT id_playlist FROM playlists WHERE (nombre LIKE '%".$query."%')";
            #$q = $this->query($pdo, $str);
            $q = $this->connect()->prepare($str);
            $q->execute();

            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
                    array_push($lista, $q->fetchColumn(0));
                    $cont++;
				}
				array_push($finallist, $lista);
			}else{ // if there is no matching rows do following
                array_push($finallist, []);
			}
			
			$personas = array();
			$str = "SELECT id_user FROM vistausuarios WHERE (username LIKE '%".$query."%')";
            #$q = $this->query($pdo, $str);
            $q = $this->connect()->prepare($str);
            $q->execute();

            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
					$persona = new User();
					$persona->setUser("", $q->fetchColumn(0));
                    array_push($lista, $persona);
                    $cont++;
				}
				array_push($personas, $lista);
			}else{ // if there is no matching rows do following
                array_push($personas, []);
			}

			$str = "SELECT id_user FROM vistaartistas WHERE (username LIKE '%".$query."%')";
            #$q = $this->query($pdo, $str);
            $q = $this->connect()->prepare($str);
            $q->execute();

            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
					$persona = new User();
					$persona->setUser("", $q->fetchColumn(0));
                    array_push($lista, $persona);
                    $cont++;
				}
				array_push($personas, $lista);
			}else{ // if there is no matching rows do following
                array_push($personas, []);
			}
			array_push($finallist, $personas);

			$str = "SELECT id_album FROM albumes WHERE (nombre LIKE '%".$query."%')";
            #$q = $this->query($pdo, $str);
            $q = $this->connect()->prepare($str);
            $q->execute();

            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
                    array_push($lista, $q->fetchColumn(0));
                    $cont++;
				}
				array_push($finallist, $lista);
			}else{ // if there is no matching rows do following
                array_push($finallist, []);
			}
			
			
			return $finallist;
        }
        else{ // if query length is less than minimum
            return [];
        }
    }

	public function borrarPlaylist($id){
		$query = $this->connect()->prepare('DELETE FROM `playlists` WHERE id_playlist = :id');
		$query->execute(['id' => $id]);
	}

	public function crearPlaylist($nombre, $descripcion){
		$query = $this->connect()->prepare('INSERT INTO `playlists`(`id_user`, `nombre`, `descripcion`) VALUES (:id,:nombre,:descripcion)');
		$query->execute(['id' => $this->id_user, 'nombre' => $nombre, 'descripcion' => $descripcion]);


		$datos = $this->connect()->prepare('SELECT MAX(id_playlist) FROM `playlists`');
		$datos->execute();

		$id = 0;
		foreach($datos as $newPlaylist){
			$id = $newPlaylist[0];
		}

		
		$query = $this->connect()->prepare('INSERT INTO `personas_playlists`(`id_user`, `id_playlist`) VALUES (:iduser,:idplaylist)');
		$query->execute(['iduser' => $this->id_user, 'idplaylist' => $id]);
	}
	
	public function getPlaylistsCreadas(){
		$query = $this->connect()->prepare('SELECT id_playlist FROM playlists WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);
		$playlistsCreadas = array();

		foreach($query as $currentId){
			$playlist = new Playlist();
			$playlist->setPlaylist($currentId['id_playlist']);
			array_push($playlistsCreadas,$playlist);
		}
		return $playlistsCreadas;
	}

	public function getSeguidores(){
		$query = $this->connect()->prepare('SELECT id_seguidor FROM personas_personas WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);
		
		$seguidores = 0;
		foreach($query as $currentId){
			$seguidores++;
		}
		return $seguidores;
	}

	public function getSeguidos(){
		return $this->seguidos;
	}

	public function setSeguidos(){
		$query = $this->connect()->prepare('SELECT id_user FROM personas_personas WHERE id_seguidor = :id');
		$query->execute(['id' => $this->id_user]);
		
		$seguidos = array();
		foreach($query as $currentId){
			$seguido = new User();
			$seguido->setUser("",$currentId['id_user']);
			array_push($seguidos,$seguido);
		}
		$this->seguidos = $seguidos;
	}

	public function insertUser($username, $pass, $type){
		if($type == "usuario"){
			$tipo = 0;
		}else{
			$tipo = 1;
		}
		$query = $this->connect()->prepare('INSERT INTO `personas`(`username`, `password`, `tipo`) VALUES (:user,:pass,:tipo)');
		$query->execute(['user' => $username, 'pass' => $pass, 'tipo' => $tipo]);
	}

	public function setCurrPlaylist($playlist){
		$this->currPlaylist = $playlist;
	}

	public function getCurrPlaylist(){
		return $this->currPlaylist;
	}

	public function getPlaylists(){
		$this->playlists = array();
		$query = $this->connect()->prepare('SELECT id_playlist FROM personas_playlists WHERE id_user = :id');
		$query->execute(['id' => $this->id_user]);
		
		foreach($query as $currentId){
			$playlist = new Playlist();
			$playlist->setPlaylist($currentId['id_playlist']);
			array_push($this->playlists,$playlist);
		}
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

	public function setUser($user = "", $id = ""){
		if($id == ""){
			$query = $this->connect()->prepare('SELECT * FROM personas WHERE username = :user');
			$query->execute(['user' => $user]);
		}else{
			$query = $this->connect()->prepare('SELECT * FROM personas WHERE id_user = :id');
			$query->execute(['id' => $id]);
		}

		foreach ($query as $currentUser) {
			$this->id_user = $currentUser['id_user'];
			$this->username = $currentUser['username'];
			$this->playlists = array();
			$this->currPlaylist = new Playlist();
			$this->isartista = false;
			$this->seguidos = array();

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

	public function editarPass($newPass){
		$query = $this->connect()->prepare('UPDATE personas SET password = :pass WHERE id_user = :id');
		$query->execute(['pass' => $newPass, 'id' => $this->id_user]);
		return "Contraseña cambiada correctamente!";
	}

	public function getNombre(){
		return $this->username;
	}

	public function editarNombre($newNombre){
		if($this->registroExists($newNombre)){
			return "Nombre no disponible!";
		}
		$query = $this->connect()->prepare('UPDATE personas SET username = :nombre WHERE id_user = :id');
		$query->execute(['nombre' => $newNombre, 'id' => $this->id_user]);
		$this->username = $newNombre;
		return "Nombre cambiado correctamente!";
	}

	public function getId(){
		return $this->id_user;
	}

	public function getBiografia(){
		return $this->biografia;
	}

	public function editarBiografia($newBiografia){
		$query = $this->connect()->prepare('UPDATE artistas SET biografia = :biografia WHERE id_user = :id');
		$query->execute(['biografia' => $newBiografia, 'id' => $this->id_user]);
		$this->biografia = $newBiografia;
	}

}

?>