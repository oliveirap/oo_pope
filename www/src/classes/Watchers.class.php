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
	/** RESTRICTIONS **/ 
	/**
	 * Redirects to a certain page and kills the system.
	 * @param $location URL to me redirected.
	 */
	public function redirect($location)
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
	 * Checks if the user can be logged
	 * @uses Look:: to check the status of the user
	 * @return bool(false) if the user can't be logged, bool(true) if it can
	 */	private function canBeLogged()
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

	/** WATCH USER ACTIONS **/

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
	 * Logout the user.
	 */
	public function logout()
	{
		unset($_SESSION['userInfo']);
		$this->userOnly();
	}

	/**
	 * Watch for question registration post attempt
	 * @uses Question::
	 * @return array $wasSet containing info 'can' => bool and 'msg' => Any message.
	 */
	public function watchNewQuestion()
	{
		if(!!getPost('submitNewQuestion'))
		{
			$question   = new Question();
			$tags       = thePost('question-tags');
			$body       = thePost('question-body');
			$difficulty = thePost('question-difficulty');
			$theAnswer  = thePost('question-answer');
			$answers    = $question->encodeAnswer(thePost('answer-text'));
			$wasSet     = $question->trySetQuestion($tags, $difficulty, $body, $answers, $theAnswer);
			return $wasSet;
			
		}
	}

	/**
	 * Watch for tests registration post attempt
	 * @uses Test::
	 */
	public function watchNewTest()
	{
		if(!!getPost('submitNewTest'))
		{
			$test        = new Test();
			$name        = thePost('testName');
			$tags        = thePost('testTags');
			$difficulty  = thePost('testDifficulty');
			$questions   = thePost('theQuestions');
			$description = thePost('testDescription');
			$wasSet      = $test->trySetTest($name, $tags, $difficulty, $questions, $description);
			return $wasSet;
		}
	}


	/**
	 * Watch for a test making. All logic will be here, i think...
	 * @uses Retriever::
	 */
	public function watchTestAnswering()
	{
		if(!empty($_SESSION['theDoer']))
		{
			$doer = new Doer();
			$doer->fromJson($_SESSION['theDoer']);
			if(!empty($_GET['aid']))
			{
				$aid = $_GET['aid'];
				return($doer->doTest($doer->currentQuestion, $aid));
			}
		}
		return null;
	}

	/**
	 * Init test answer
	 */
	public function initTest()
	{
		if(empty($_SESSION['theDoer']))
		{
			if(empty($_GET['tid']))
			{
				/** Deve mostrar o buscador de listas **/
				echo "Por favor, selecione uma lista.";
			}
			else if(empty($_GET['qid']))
			{
				/** Redireciona para a primeira questão da lista **/
				$this->redirect("?tid=" . $_GET['tid'] . "&qid=1");
			}
			else
			{
				$tid  = $_GET['tid'];
				$qid  = $_GET['qid'];
				$userkey = $_SESSION['userInfo']['userkey'];
				$doer = new Doer();
				$can  = $doer->trySet($userkey, $tid, $qid);
				if($can['can'])
				{
					return $can;
				}
				else
				{
					unset($doer);
					return $can;
				}
			}
		}
	}
}
