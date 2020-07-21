<?php

include_once 'user.php';

session_start();
$user = new User();

if(isset($_SESSION['user'])){
	header("location: home.php");
}else if (isset($_POST['username']) && isset($_POST['password'])) {
	$userForm = $_POST['username'];
	$passForm = $_POST['password'];

	if($user->userExists($userForm, $passForm)){
		$_SESSION['user'] = $userForm;

		header("location: home.php");
	}else{
		$errorLogin = "nombre de usuario y/o contraseña incorrecta";
		include_once 'login.php';
	}
}else{
	include_once 'login.php';
}
?>