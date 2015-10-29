<?php
/**
 * POPE Regex Class
 *
 * @category  Validação de Inputs
 * @package   POPE - Plataform For Online Problems and Exercises
 * @author    Pedro Oliveira <pedroliveira007@hotmail.com>
 * @copyright Copyright (c) 2015
 * @license   http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @version   1.0.0
 **/
class Regex{

	/**
	 * User Register validations
	 **/
	public function validateUser($usuario){
		$regex = "/^[a-zA-Z0-9_@%#$&!\\\.-\\\']{3,16}$/";
		return preg_match($regex, $usuario);
	}
	public function validatePass($senha){
		$regex = "/^[a-z0-9A-Z_@%$#&!.-]{6,}$/";
		return preg_match($regex, $senha);
	}
	public function validateTicket($ticket){
		$regex = "/^[a-z0-9A-Z]{12}$/";
		return preg_match($regex, $ticket);
	}
	public function validateName($nome){
		$nome = str_replace(" ", "", $nome);
		$regex = "/^[a-zA-Z0-9]{11,}$/";
		return preg_match($regex, $nome);
	}
	public function validateMatr($matr){
		$regex = "/^[0-9]{14}$/";
		return preg_match($regex, $matr);
	}
	public function validateEmail($email){
		$regex = "/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/";
		return preg_match($regex, $email);
	}

	/**
	 * Question Register validations
	 **/
	public function validateQuestionTags($tags)
	{
		$regex = "/^[\w\d\s]+$/";
		return preg_match($regex, $tags);
	}
	public function validateQuestionBody($body)
	{
		$body = strip_tags($body);
		$body = str_replace(" ", "", $body);
		$len = strlen($body);
	}
}
?>