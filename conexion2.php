<?php

class DB{    
    private $host;
    private $user;
    private $password;
    private $db;
    private $charset;
    public $connection;
    public function __construct(){
    	$this->host ="localhost";
	    $this->user ="root";
	    $this->password  ="";
	    $this->db ="Poyofy";
	    $this->charset = 'utf8mb4';

	}

	public function connect(){
		try{
	        $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;

	        $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_EMULATE_PREPARES => false];

	        $pdo = new PDO($connection, $this->user, $this->password, $options);
	        return $pdo;

		}catch(PDOException $e){
			print_r("Error connection: " . $e->getMessage());
		}

	}
}

?>