<?php
init();

function init(){
	session_start();

	/**
	* Chama config.php
	*/
	$config = $_SERVER['DOCUMENT_ROOT'] . "/oo_pope/www/config.php";

	if(!file_exists($config))
	{
		die("Fatal Error: Configuration not found.");
	}
	else
	{
		require_once($config);
	}
	if(!file_exists(FILE_AUTOLOADER)){
		die("Error: Autoloader not found.");
	}
	else{
		require_once(FILE_AUTOLOADER);
	}
}
?>