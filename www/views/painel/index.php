<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$watcher = new Watchers();
$watcher->userOnly();
$watcher->watchLogout();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>POPE</title>
</head>
<body>
	Hello, <?php echo firstName(getInfo("name")) ?>
	This page can only by accessed by users;
	<?php require_once(DIR_PARTIALS . "nav.php") ?>
</body>
</html>