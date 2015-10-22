<?php 
/**
 * POPE Look Class
 *
 * @category  Pesquisa em DB
 * @package   POPE - Plataform For Online Problems and Exercises
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
**/

class Look
{
	/**
	 * Checks if the user is already in use
	 * @uses Database:: functions
	 * @param $user user to check for
	 * @return bool(true) if it is already in use, bool(false) elsewise
	 */
	public function userExists($user)
	{
		$db = Conectar();
		$db->set_table_prefix(DB_PREFIX);
		$db->select()->from("users")->where("username", $user)->execute();
		$affected = $db->affected_rows;
		if($affected > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Checks if the email is already in use
	 * @uses Database:: functions
	 * @param $email Email to check for
	 * @return bool(true) if it is already in use, bool(false) elsewise
	 */
	public function emailExists($email)
	{
		$db = Conectar();
		$db->set_table_prefix(DB_PREFIX);
		$db->select()->from("users")->where("email", $email)->execute();
		$affected = $db->affected_rows;
		if($affected > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Checks the status of the user
	 * @uses Database:: functions
	 * @param $userkey Userkey of the user to check for
	 * @return bool(true) if status = 1, bool(false) elsewise
	 */
	public function getStatus($userkey)
	{
		$userkey  = escape($userkey);
		$db       = Conectar();
		$data     = $db->select('status')->from("users")->where("userkey", $userkey)->fetch();
		if(!empty($data) && isset($data[0]["status"]) && $data[0]["status"] == 1)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
	

}
?>