<?php 
	// Gets

	/**
	* Returns all post data or only the specified one, already escaped
	* @param $key Value to be returned.
	* @return array
	 */
	function getPost($key = null)
	{
		if($key === null)
			return $_POST;
		else
			return (isset($_POST[$key])) ? escape($_POST[$key]) : false;
	}
	function thePost($key = null)
	{
		if($key === null)
		{
			return $_POST;
		}
		else if(isset($_POST[$key]))
		{
			return $_POST[$key];
		}
		else
		{
			return null;
		}
	}

	// Sets

	/**
	* Create the instance of the connection. Just a shortcut
	* @uses Database::
	* @return object The object of the connection. 
	 */
	function Conectar(){
		$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$db->set_table_prefix(DB_PREFIX);
		return $db;
	}

	/**
	* Encripts a given string with sha512 hash. Used for passwords
	* @param $pass String to be encripted.
	* @return string password
	 */
	function encriptPass($pass)
	{
		if($pass != "")
		{
			return hash('sha512', $pass);
		}
		else
		{
			return false;
		}
	}

	/**
	* Escape a string or array. 
	* @param $args string/array to be escaped.
	 * @return array
	 */
	function escape($args)
	{
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die(mysqli_connect_error());
		mysqli_set_charset($conn, DB_CHARSET) or die(mysqli_error($conn));
		if(!is_array($args))
		{
			return mysqli_real_escape_string($conn, strip_tags($args));
		}
		else
		{
			foreach ($args as $key => $value) {
				$value = mysqli_real_escape_string($conn, strip_tags($value));
				$args[$key] = $value;
			}
			return $args;
		}
	}

	function escapeWithTags($args)
	{
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die(mysqli_connect_error());
		mysqli_set_charset($conn, DB_CHARSET) or die(mysqli_error($conn));
		if(!is_array($args))
		{
			return mysqli_real_escape_string($conn, $args);
		}
		else
		{
			foreach ($args as $key => $value) {
				$newValue = mysqli_real_escape_string($conn, $value);
				$data[$key] = $newValue;
			}
			return $data;
		}
	}

	/**
	 * Encodes the $doer->completedObjectives array to a string
	 * 40:alt-3,alt-2,alt-1(05:30)
	 * @param the array the Objectives
	 * @return string questionNumber:alt-3,alt-4,alt-5(05:30); [...]
	 */
	function encodeLog($arr)
	{
		if(!is_array($arr) || empty($arr))
		{
			return false;
		}
		else
		{
			foreach($arr as $key => $value)
			{
				if(!array_key_exists("sequence", $value) || !array_key_exists("time", $value) || empty($value['sequence']) || empty($value['time']))
				{
					return false;
				}
			}
			$encoded = "";
			foreach($arr as $key => $value)
			{
				$encoded .= $key . ":" . $value['sequence'] . "(" . $value['time'] . ");";
			}
			return $encoded;
		}

	}

	/**
	* Generates a userkey.
	 */
	function generateKey()
	{
		return sha1(rand().time());
	}

	/**
	 * TRIMS the name on the first space back
	 * @param $name String
	 * @return string $name trimmed
	 */
	function firstName($name)
	{
		$i = strpos($name, " ");
		if($i === false)
		{
			return $name;
		}
		else
		{
			return substr($name, 0, $i);
		}
	}

	/**
	 * Returns the user info stored on $_SESSION['userInfo']
	 * @param string $field field to return the value
	 * @return $value the value on the field
	 */
	function getInfo($field)
	{
		if(!empty($_SESSION['userInfo'][$field]))
		{
			return $_SESSION['userInfo'][$field];
		}
	}
	
	/**
	 * Checks if the same form is been sent again.
	 */
	function isNewPost()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$request = md5(json_encode($_POST));
			if(isset($_SESSION['last_request']) && $_SESSION['last_request'] == $request)
			{
				return false;
			}
			else
			{
				$_SESSION['last_request'] = $request;
				return true;
			}
		}
	}
