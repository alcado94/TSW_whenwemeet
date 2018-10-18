<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");

/**
* Class UserMapper
*
* Database interface for User entities
*
* @author lipido <lipido@gmail.com>
*/
class UserMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

	/**
	* Saves a User into the database
	*
	* @param User $user The user to be saved
	* @throws PDOException if a database error occurs
	* @return void
	*/
	public function save($user) {
		$stmt = $this->db->prepare("INSERT INTO usuarios values (NULL,?,?,?,?)");
		$stmt->execute(array($user->getName(), $user->getSurname(), $user->getLogin(), $user->getPasswd() ));
	}

	/**
	* Checks if a given username is already in the database
	*
	* @param string $username the username to check
	* @return boolean true if the username exists, false otherwise
	*/
	public function usernameExists($username) {
		$stmt = $this->db->prepare("SELECT count(login) FROM usuarios where login=?");
		$stmt->execute(array($username));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}

	public function getUser($username) {
		$stmt = $this->db->prepare("SELECT * FROM usuarios where login=?");
		$stmt->execute(array($username));
		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($user != NULL) {
			return new User($user["idusuarios"], $user["nombre"], $user["apellidos"], $user["login"], $user["contrasena"]);
		}
		else{
			return NULL;
		}
			
	}

	/**
	* Checks if a given pair of username/password exists in the database
	*
	* @param string $username the username
	* @param string $passwd the password
	* @return boolean true the username/passwrod exists, false otherwise.
	*/
	public function isValidUser($username, $passwd) {
		$stmt = $this->db->prepare("SELECT count(login) FROM usuarios where login=? and contrasena=?");
		$stmt->execute(array($username, $passwd));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}
}
