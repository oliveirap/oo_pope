<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$watcher = new Watchers();
$watcher->userOnly();
$watcher->watchLogout();
($watcher->watchTestAnswering());
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
		$doer = new Doer($_SESSION['userInfo']['userkey'], "486fc6f374760d763a7325232841098c5e6b95cf");
		$doer->doTest(2, "alt-1");
		$doer->doTest(2, "alt-2");
		$doer->doTest(2, "alt-3");
		$doer->doTest(2, "alt-4");
		$doer->doTest(1, "alt-4");
		$doer->doTest(1, "alt-5");
		print_r($doer);
		echo "</pre>";
		//$doer = new Doer();
	?>

</body>
</html>