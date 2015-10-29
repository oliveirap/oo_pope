<?php
/**
 * POPE Watchers Class
 * This class is responsible for checking post attemps (such as login, inserting a new question) and invoking the respective functions to do so.
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
			$this->redirect(URL_BASE);
		}
	}

	/**
	 * Restrict the access for only admin users
	 */
	public function adminOnly()
	{
		if(!$this->isLogged())
		{
			$this->redirect(URL_BASE);
		}
		else
		{
			if($_SESSION['userInfo']['type'] != 3)
			{
				$this->redirect(URL_BASE);
			}
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
			$this->redirect(URL_PAINEL);
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
	 * Watch for logout URL
	 * @uses $this->logout();
	 */
	public function watchLogout()
	{	
		if(isset($_GET['logout']))
		{
			$this->logout();
		}
	}

	/**
	 * Watch for Login post attempt
	 * @uses Login::
	 */
	public function watchLogin()
	{
		if(!!getPost('login'))
		{
			$login = new Login(getPost('username'), getPost('password'));
			$canLogin = $login->tryLogin();
			if(!$canLogin)
			{
				echo "Usuário e/ou senha incorreto.";
			}
		}
	}

	/**
	 * Watch for question registration post attempt
	 * @uses Question::
	 */
	public function watchNewQuestion()
	{
		if(!!getPost('submitNewQuestion'))
		{
			if(!empty($_POST['answer-text']) && array_filter($_POST['answer-text']))
			{
				$question = new Question();
				$tags = isset($_POST['question-tags']) ? $_POST['question-tags'] : null;
				$body = isset($_POST['question-body']) ? $_POST['question-body'] : null;
				$theAnswer = isset($_POST['question-answer']) ? $_POST['question-answer'] : null;
				$answers = isset($_POST['answer-text']) ? $question->encodeAnswer($_POST['answer-text']) : null;
				$wasSet = $question->trySetQuestion($tags, $body, $answers, $theAnswer);
				return $wasSet;
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