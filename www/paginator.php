<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/system.php");
$retriever = new Retriever();
$data = $retriever->retrieveQuestion();
$paginator = new Paginator(1,5, $data);
echo "<pre>";
print_r($paginator->plotResults(1));
echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test Paginator</title>
</head>
<body>
	
</body>
</html>