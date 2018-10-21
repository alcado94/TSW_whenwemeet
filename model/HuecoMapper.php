<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/Encuesta.php");
require_once(__DIR__."/Hueco.php");
/**
* Class UserMapper
*
* Database interface for User entities
*
* @author lipido <lipido@gmail.com>
*/
class HuecoMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
    }
	

	public function save(Hueco $hueco) {
		$stmt = $this->db->prepare("INSERT INTO huecos(encuestas_idencuestas, fecha_inicio, fecha_fin) values (?,?,?)");
		$stmt->execute(array($hueco->getEncuestas_idencuestas(), $hueco->getFechaInicio(), $hueco->getFechaFin()));
		return $this->db->lastInsertId();
	}
}
