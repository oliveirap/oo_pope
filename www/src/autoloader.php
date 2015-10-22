<?php 
	function __autoload($classe)
	{
	   require_once (DIR_CLASSES . "{$classe}.class.php");
	}

	$helpers = DIR_SRC . "helpers.php";
	if(file_exists($helpers))
	{
		require_once($helpers);
	}
	else
	{
		die("Error: Helpers file not found.");
	}
?>