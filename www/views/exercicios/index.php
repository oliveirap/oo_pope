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
	<?php 
		require_once(DIR_PARTIALS . "nav.php");
		if(empty($_GET['tid']))
		{
			echo "Por favor, selecione uma lista.";
		}
		else if(empty($_GET['qid']))
		{
			$watcher->redirect("?tid=" . $_GET['tid'] . "&qid=1");
		}
		else
		{
			echo "Vai imprimir questão " . $_GET['qid'] .  " da lista " .  $_GET['tid'];
		}

	?>
</body>
</html>