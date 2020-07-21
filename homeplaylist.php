<?php

include_once 'user.php';
include_once 'user_session.php';

$userSession = new UserSession();
$user = new User();
/**/
$username = $userSession->getCurrentUser();
$user->setUser($userSession->getCurrentUser());
$user->isArtista($user->getId());

if($user->getIsArtista()){
	$user->setBiografia($user->getId());
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Playlist</title>
</head>
<body>
	<h1>Playlists</h1>
	<l4>Playlists de  <?php echo $user->getNombre(); ?>! </l4>

	<li class="volver">
		<a href="index.php">Volver</a>
	</li>
	<br><br>
	<?php
		$user->setPlaylistsSeguidas($user->getId());
		$user->getPlaylistsSeguidas();
	?>

</body>
</html>