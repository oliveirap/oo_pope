<?php
/**
 * POPE Watchers Class
 *
 * @category  Watcher
 * @package   POPE - Plataform For Online Problems and Exercises
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
 **/

class Watchers
{
	/**
	 * Redirects to a certain page and kills the system.
	 * @param $location URL to me redirected.
	 */
	private function redirect($location)
	{
		header("location:" . $location);
		die();
	}

	/**
	 * Restrict the access for only logged users
	 * @uses self::isLogged and self::redirect
	 */
	public function userOnly()
	{
		if(!$this->isLogged())
		{
			$this->redirect("http://facebook.com");
		}
	}

	/**
	 * Restrict the access for only non-logged users
	 * @uses self::isLogged and self::redirect
	 */
	public function publicOnly()
	{
		if($this->isLogged())
		{
			$this->redirect("http://youtube.com");
		}
	}
	

	/**
	 * Checks if the user is Logged.
	 * @return bool(true) if it is, bool(false) elsewise
	 */
	public function isLogged()
	{
		if(!isset($_SESSION['userInfo']) || empty(($_SESSION['userInfo'])) )
		{
			return false;
		}
		else
		{
			if(!$this->canBeLogged())
			{
				$this->logout();
				return false;
			}
			else
			{
				return true;
			}
		}
	}

	/**
	 * Logout the user.
	 */
	public function logout()
	{
		unset($_SESSION['userInfo']);
		$this->userOnly();
	}

	/**
	 * Checks if the user can be logged
	 * @uses Look:: to check the status of the user
	 * @return bool(false) if the user can't be logged, bool(true) if it can
	 */
	private function canBeLogged()
	{
		$look = new Look();
		$userkey = $_SESSION['userInfo']['userkey'];
		if($look->getStatus($userkey))
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