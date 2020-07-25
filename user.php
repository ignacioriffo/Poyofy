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
	private $seguidos;

	function searchSongs($string){
        $query = $string;
        $min_length = 1;
        // you can set minimum length of the query if you want
		if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
            $query = htmlspecialchars($query); 
            // changes characters used in html to their equivalents, for example: < to &gt;
            $str = "SELECT id_cancion FROM canciones WHERE (nombre LIKE '%".$query."%')";
            #$q = $this->query($pdo, $str);
            $q = $this->connect()->prepare($str);
            $q->execute();
            // * means that it selects all fields, you can also write: id, title, text
            // articles is the name of our table

            // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
            // it will match "hello", "Hello man", "gogohello", if you want exact match use title='$query'
            // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
            $numResults = $q->rowCount();
            $lista = [];
            if($numResults > 0){ // if one or more rows are returned do following
                $cont = 0;
                while($cont < $numResults){
                    array_push($lista, $q->fetchColumn(0));
                    $cont++;
                }
                return $lista;
            }
            else{ // if there is no matching rows do following
                return [];
            }
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
		$query = $this->connect()->prepare('INSERT INTO `personas`(`username`, `password`) VALUES (:user,:pass)');
		$query->execute(['user' => $username, 'pass' => $pass]);

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

	public function getNombre(){
		return $this->username;
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