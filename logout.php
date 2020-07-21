<?php
	session_start();

	if(!isset($_SESSION['user'])){
	  header('Location: login.php');
	}

	session_unset();
	session_destroy();
	
	header("location: index.php");
	exit();
?>