<?php 
/**
 * POPE Look Class
 * This class is used for check disponibility, check if parameters match. Functions will always return true or false.
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
	 * Checks if the ticket is good for registration
	 * @uses Database::, Regex::validateTicket()
	 * @param $ticket Ticket to be checked on database
	 * @return bool(false) if can't be used, bool(true) elsewise
	 */
	public function checkTicket($ticket)
	{
		if(!empty($ticket) && Regex::validateTicket($ticket))
		{
			$db = Conectar();
			$sql = "SELECT * FROM pp_regcode WHERE cod = '$ticket'";
			$data = $db->query($sql)->fetch();
			$lim = $data[0]['lim'];
			$reg = $data[0]['reg'];
			if($reg < $lim)
			{
				return true;
			}
			else
			{
				return false;
			}
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

	/**
	 * Checks if is the correct answer
	 * @param $correct The Correct answer
	 * @param $marked The marked answer
	 * @return bool(true) if correct, bool(false) elsewise
	 */
	
	public function isCorrectAnswer($correct, $marked)
	{
		if($correct == $marked)
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