<?php
/**
 * POPE Login Class
 *
 * @category  Login Check
 * @package   POPE - Plataform For Online Problems and Exercises
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
 **/
class Login extends User
{
	public function __construct($username, $password)
	{
		$this->user = addslashes($username);
		$this->pass = encriptPass($password);
	}

	/**
	* Check if login credentials are right
	* @uses User:: for setting the user if it does
	* @return Set session with $this->setLogin() or return false.
	 */
	public function tryLogin()
	{
		$db     = Conectar();
		$tb     = "users";
		$select = 'name, email, username, userkey, registred, type';
		$where  = array(
				"username" => $this->user,
				"password" => $this->pass,
				"status"   => 1
			);
		$db->select($select)->from($tb)->where($where)->execute();

		if($db->affected_rows > 0)
		{
			$data = $db->select($select)->from($tb)->where($where)->fetch();
			$this->setLogin($data);
		}
		else
		{
			return false;
		}
	}

	/**
	* Set the session
	* @return bool(true) if logged, bool(false) if not.
	 */
	private function setLogin($data = null)
	{
		if(is_array($data) && array_filter($data))
		{
			$data = $data[0];
			foreach ($data as $key => $value) {
				$_SESSION['userInfo'][$key] = $value;
			}
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>