<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$watcher = new Watchers();
$watcher->userOnly();
$watcher->watchLogout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lista X</title>
</head>
<body>
	Responder Lista.
</body>
</html>