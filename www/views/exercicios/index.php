<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$watcher = new Watchers();
$watcher->userOnly();
$watcher->watchLogout();
$watcher->initTest();

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
		echo "<pre>";
		$watcher->watchTestAnswering();
		$debug = new Doer();
		$debug->fromJson($_SESSION['theDoer']);
		print_r($debug);
		echo "</pre>";
		//$doer = new Doer();
	?>

</body>
</html>