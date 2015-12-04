<?php
	/**
	 * POPE DOER Class
	 *
	 * THIS IS THE MASTER CLASS.
	 * THE CLASS OF HEROES
	 * THE CLASS OF WINNERS
	 * THE CLASS FOR GOOD STUDENTS THAT DO STUDIES
	 * FOR THERE IS NO BETTER WAY TO BE THAN BEING A DOER
	 * BE A DOER RIGHT NOW!!!!!!! GO AND TAKE A TASK, ANSWER QUESTIONS AND ACHIEVE GLORY, HONOR, POWER.
	 *
	 * "DON'T LET YOUR DREAMS BE DREAMS. JUST DO IT!" - Shia LaBeouf.
	 *
	 * @category  WINNERS CLASSES
	 * @package   POPE - Plataform For Online Problems and Exercises
	 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
	 * @copyright Copyright (c) 2015
	 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
	 * @version   1.0.0
	 **/
	class Doer
	{
		/** THE DOER SHALL IDENTIFY HIMSELF **/
		protected $theDoer    = null;
		/** EVERY DOER IS A WINNER, UNLESS HE QUITS THE TASK BEFORE IT IS DONE! **/
		protected $isWinner   = true;
		/** ONE SHALL PASS THROUGH NUMEROUS TESTS, AND ON EACH ON HE OUGHT TO ACHIEVE RIGHTNESS **/
		protected $hasHonor   = false;
		/** THE MORE TESTS ONE TAKES AND SUCCEEDS, MORE HONOR LEVELS HE WILL ACHIEVE. **/
		protected $honorLevel = 0;
		/** EVERY DOER SHALL HAVE A TASK TO TAKE **/
		protected $theTask = array();
		/** EVERY TASK HAS ITS OBJECTIVES **/
		protected $theObjectives = array();
		/** AND THE OBJECTIVES ACHIEVED SHALL BE REGISTERED **/
		protected $completedObjectives = array();
		/** HE BE FOCUSED ON THE OBJECTIVE **/
		public    $currentQuestion =  1;
		/**
		 * A DOER KNOW HIS TASK SINCE THE START!!!
		 * @param string $doerkey the userkey
		 * @param string $tid THE DOER TASK ID
		 * @param int $qid THE DOER CURRENT QUESTION
		 * @return array('can' => bool, 'msg' => 'Any msg')
		 */

		public function trySet($doerkey = null, $tid = null, $qid = 1)
		{
			if(empty($_SESSION['theDoer']))
			{
				$isDoer = Look::userkeyExists($doerkey);
				if($isDoer)
				{
					$this->theDoer = $doerkey;
					$accepted      = $this->acceptTheTask($tid);
					$isAObjective  = $this->isAObjective(null, $qid);
					if($accepted['can'] && $isAObjective['can'])
					{
						$firstQuestion = $this->theObjectives[0];
						$this->completedObjectives[$firstQuestion]['startedTime'] = date("Y-m-d H:i:s");
						$this->toJson();
						return array(
								'can' => true
							);
					}
					else if(!$accepted['can'])
					{
						return $accepted;
					}
					else
					{
						return $isAObjective;
					}
				}
				else
				{
					return array(
							'can' => false,
							'msg' => 'Usuário inválido'
						);
				}
			}
			else
			{
				$this->fromJson($_SESSION['theDoer']);
			}
		}

		/**
		 * Sets $this->theTask
		 * @uses Retriever::retrieveTest
		 * @param string $tid The testkey to be set
		 * @return array('can' => bool, 'msg' => 'Any msg')
		 */
		private function acceptTheTask($tid)
		{
			$retriever = new Retriever();
			$task = $retriever->retrieveTest(null, null, $tid);
			if(array_filter($task))
			{
				$task = $task[0];
				$this->theTask = $task; 
				$this->theObjectives = explode(",", $task['questions']);
				foreach ($this->theObjectives as $key => $value)
				{
					$this->completedObjectives[$value] = array(
							'completed' => false,
							'sequence'  => '',
							'startedTime' => '',
							'completedTime'      => ''
						);
				}
				return array(
						'can' => true,
						'msg' => 'Task accepted.'
					);
			}
			else 
			{
				return array(
						'can' => false,
						'msg' => 'Ocorreu um erro.'
					);
			}
		}

		/**
		 * Sees if the question exists on the test.
		 * @param $tid string test to look into, can be null if $this->theTask is set;
		 * @param $qid int question to check
		 * @return array('can' => bool, 'msg' => 'Any msg')
		 */
		private function isAObjective($tid = null, $qid = 1)
		{
			if(!empty($this->theTask) && $qid < sizeof($this->theObjectives))
			{
				return array(
						'can' => true,
						'msg' => 'The objective exists'
					);
			}
			else if(empty($this->theTask))
			{
				$accepted = $this->acceptTheTask($tid);
				if($accepted['can'])
				{
					$this->isAObjective(null, $qid);
				}
				else
				{
					return $accepted;
				}
			}
			else
			{
				return array(
						'can' => false,
						'msg' => 'This is not a objective'
					);
			}
		}

		/**
		 * Step by Step Task doing
		 * @param int $qnumber int number of the question
		 * @param string $answer string marked Answer
		 * @return bool(true/false) if user is correct or not
		 */
		public function doTest($qnumber, $answer)
		{
			$qnumber   = $qnumber - 1;
			if(($answer == "alt-5"
                    || $answer == "alt-1"
                    || $answer == "alt-2"
                    || $answer == "alt-3"
                    || $answer == "alt-4")
					&& array_key_exists($qnumber,$this->theObjectives)
			)
			{
				$qid       = $this->theObjectives[$qnumber];
				$completed = $this->completedObjectives[$qid]['completed'];
				if(Look::isCorrectAnswer($qid, $answer))
				{
					if(!$completed)
					{
						$this->completedObjectives[$qid]['completed']  = true;
						$this->completedObjectives[$qid]['completedTime'] = date("Y-m-d H:i:s");
						$this->completedObjectives[$qid]['sequence']  .= "$answer";
						if($this->currentQuestion + 1 <= sizeof($this->theObjectives))
						{
							$this->currentQuestion = $this->currentQuestion + 1;
							$qid = $this->theObjectives[($this->currentQuestion - 1)];
							$this->completedObjectives[$qid]['startedTime'] = date("Y-m-d H:i:s");
						}
					}
					$done = $this->isDone();
					$this->toJson();
					if($done)
					{
						return array(
								$qnumber => true, 'done' => true);
					}
					else
					{
						$retriever = new Retriever();
						$data = $retriever->retrieveQuestion(null, null,
								$this->theObjectives[$this->currentQuestion - 1],
								true);
						return array($qnumber => true, 'done' => false, 'next' => $data);
					}
				}
				else
				{
					if(!$completed)
					{
						if(strpos($this->completedObjectives[$qid]['sequence'], "$answer") === false)
						{
							$this->completedObjectives[$qid]['sequence'] .= $answer . ",";
						}
					}
					$this->toJson();
					return array($qnumber => false, 'done' => false);
				}
			}
			else
			{
				return array($qnumber => false, 'done' => false);
			}
		}

		/**
		 * Inserts log on pp_logs. First on testsAnswersLog, then on questionsAnswersLog.
		 * WILL BE CHANGED
		 */
		private function logHonor()
		{
			if($this->hasHonor)
			{
				$db = Conectar();
				$tb = DB_PREFIX . 'testsanswerslog';
				$qtb = DB_PREFIX . 'questionsanswerslog';
				$questionsTime = array();
				/** CALCULATES TOTAL TEST TIME **/
				$testTime = date_create('00:00:00');
				foreach ($this->completedObjectives as $completedObjective)
				{
					/** TIME OF EACH QUESTION */
					$startedTime   = date_create($completedObjective['startedTime']);
					$completedTime = date_create($completedObjective['completedTime']);
					$interval      = date_diff($startedTime, $completedTime);
					$testTime      = date_add($testTime, $interval);
					array_push($questionsTime, $interval);
				}
				$data = array(
							'listId' => $this->theTask['listkey'],
							'userId' => $this->theDoer,
							'time'   => $testTime->format('H:i:s')
				);
				$id = $db->insert($tb, $data);
				foreach ($questionsTime as $key => $value)
				{
					$qid = $this->theObjectives[$key];
					$sequence = explode(',', $this->completedObjectives[$qid]['sequence']);
					foreach ($sequence as $attempt => $alternative)
					{
						$data = array(
									'questionId'    => $qid,
									'attempt'       => ($attempt+1),
									'answer'        => $alternative,
									'testanswersid' => $id,
									'questionTime'  => $value->format('%H:%I:%s')
						);
						$db->insert($qtb, $data);
					}
				}
			}
		}

		/**
		 * Encodes the object as json
		 */
		public function toJson()
		{
			$json = json_encode(array(
					'theDoer'             => $this->theDoer,
					'isWinner'            => $this->isWinner,
					'hasHonor'            => $this->hasHonor,
					'honorLevel'          => $this->honorLevel,
					'theTask'             => json_encode($this->theTask),
					'theObjectives'       => json_encode($this->theObjectives),
					'completedObjectives' => json_encode($this->completedObjectives),
					'currentQuestion'     => $this->currentQuestion
				));
			$_SESSION['theDoer'] = $json;
		}

		/**
		 * Decodes de the object from a json
		 * @param string $json
		 * @return bool for success/failure
		 */
		public function fromJson($json)
		{
			$json                        = json_decode($json, true);
			if(!empty($json['theTask']) && !empty($json['theObjectives']) && !empty($json['completedObjectives']))
			{
				$json['theTask']             = json_decode($json['theTask'], TRUE);
				$json['theObjectives']       = json_decode($json['theObjectives'], TRUE);
				$json['completedObjectives'] = json_decode($json['completedObjectives'], TRUE);
				if(empty($json['theDoer']) || empty($json['theTask']) || empty($json['theObjectives']) || empty($json['completedObjectives']))
				{
					echo 'error';
					return false;
				}
				else
				{
					$this->theDoer             = $json['theDoer'];
					$this->isWinner            = $json['isWinner'];
					$this->hasHonor            = $json['hasHonor'];
					$this->honorLevel          = $json['honorLevel'];
					$this->theTask             = $json['theTask'];
					$this->theObjectives       = $json['theObjectives'];
					$this->completedObjectives = $json['completedObjectives'];
					$this->currentQuestion     = $json['currentQuestion'];
					return true;
				}
			}
		}

		/**
		 * @return bool
         */
		private function isDone()
		{
			$completed = true;
			foreach ($this->completedObjectives as $questao => $propriedades)
			{
				if(!!!$propriedades['completed'])
				{
					$completed = false;
				}
			}
			if($completed)
			{
				$this->hasHonor = true;
				$this->logHonor();
				return true;
			}
			return false;
		}
	}

