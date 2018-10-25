<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/Encuesta.php");
require_once(__DIR__."/Huecos_has_usuarios.php");
/**
* Class UserMapper
*
* Database interface for User entities
*
* @author lipido <lipido@gmail.com>
*/
class HuecohasUsuariosMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
    }
	

	public function modify(Hueco_has_usuarios $hueco) {
		$stmt = $this->db->prepare("UPDATE huecos_has_usuarios SET estado = ? WHERE idhuecos = ? AND usuarios_idusuarios = ?");
		$stmt->execute(array( $hueco->getEstado(), $hueco->getId(), $hueco->getUsuarios_idusuarios()->getId()));
		return $this->db->lastInsertId();
	}

	public function existHueco(Hueco_has_usuarios $hueco) {
		$stmt = $this->db->prepare("SELECT count(idhuecos) FROM huecos_has_usuarios where idhuecos=? and usuarios_idusuarios=?");
		$stmt->execute(array($hueco->getId(), $hueco->getUsuarios_idusuarios()->getId()));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}
	
	public function defaultAllHueco($user, $hueco) {
		$stmt = $this->db->prepare("UPDATE huecos_has_usuarios SET estado = 0 WHERE idhuecos = ? AND usuarios_idusuarios = ?");
		$stmt->execute(array($hueco->getId(), $user->getId()));

		if ($stmt->fetchColumn() > 0) {
			return true;
		}
	}
}