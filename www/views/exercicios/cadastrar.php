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
	<title>Nova Questão</title>
</head>
<body>
<?php require_once(DIR_PARTIALS . "nav.php") ?>
<p>Olá, <?php echo firstName(getInfo('name')) ?>.</p>
<p>Esta página é exclusiva de administradores.</p>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</body>
</html>