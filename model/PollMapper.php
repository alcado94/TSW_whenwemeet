<?php
// file: model/UserMapper.php

require_once(__DIR__."/../core/PDOConnection.php");
require_once(__DIR__."/Encuesta.php");
/**
* Class UserMapper
*
* Database interface for User entities
*
* @author lipido <lipido@gmail.com>
*/
class PollMapper {

	/**
	* Reference to the PDO connection
	* @var PDO
	*/
	private $db;

	public function __construct() {
		$this->db = PDOConnection::getInstance();
	}

    

	public function findall($user) {

        $stmt = $this->db->prepare("SELECT DISTINCT idencuestas, usuarios_idcreador, titulo, fecha_creacion, nombre, apellidos 
			FROM 
				(SELECT DISTINCT * FROM 
					(SELECT DISTINCT huecos.encuestas_idencuestas FROM encuestas, huecos_has_usuarios, huecos 
						WHERE huecos_has_usuarios.usuarios_idusuarios = ? AND huecos_has_usuarios.idhuecos = huecos.encuestas_idencuestas ) 
					AS Tab, encuestas WHERE encuestas.idencuestas = Tab.encuestas_idencuestas) 
				AS SEC, usuarios WHERE usuarios.idusuarios = SEC.usuarios_idcreador");
		$stmt->execute(array($user));
		$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$polls = array();

		foreach ($poll_db as $poll) {
			array_push($polls, new Encuesta( $poll["idencuestas"], new User($poll["usuarios_idcreador"],$poll["nombre"],$poll["apellidos"]), $poll["titulo"], $poll["fecha_creacion"]));
		}

		$stmt = $this->db->prepare("select * from encuestas,usuarios where encuestas.usuarios_idcreador = ? and encuestas.usuarios_idcreador=usuarios.idusuarios");
		$stmt->execute(array($user));
		$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($poll_db as $poll) {
			array_push($polls, new Encuesta( $poll["idencuestas"], new User($poll["usuarios_idcreador"],$poll["nombre"]), $poll["titulo"], $poll["fecha_creacion"]));
		}

		return $polls;
	}

	

}
