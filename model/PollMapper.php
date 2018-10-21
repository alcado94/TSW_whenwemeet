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

    

	public function findall() {
				
		$stmt = $this->db->prepare("SELECT DISTINCT encuestas.idencuestas, encuestas.titulo, encuestas.fecha_creacion, usuarios.idusuarios, usuarios.nombre, usuarios.apellidos 
			FROM usuarios, encuestas, 
				(SELECT DISTINCT huecos.encuestas_idencuestas FROM huecos, huecos_has_usuarios 
					WHERE huecos_has_usuarios.usuarios_idusuarios=? AND huecos_has_usuarios.idhuecos=huecos.idhueco) AS part
			WHERE (usuarios.idusuarios=encuestas.usuarios_idcreador AND encuestas.usuarios_idcreador=?) 
				OR part.encuestas_idencuestas=encuestas.idencuestas AND usuarios.idusuarios=encuestas.usuarios_idcreador");
		
		$stmt->execute(array($_SESSION["currentuser"],$_SESSION["currentuser"]));
		$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);


		$polls = array();

		foreach ($poll_db as $poll) {
			$stmt2 = $this->db->prepare("SELECT COUNT(DISTINCT huecos_has_usuarios.usuarios_idusuarios) FROM huecos, huecos_has_usuarios
				WHERE huecos.encuestas_idencuestas=? AND huecos.idhueco=huecos_has_usuarios.idhuecos");
				
			$stmt2->execute(array($poll["idencuestas"]));
			$num = $stmt2->fetchColumn();
			
			array_push($polls, new Encuesta( $poll["idencuestas"], new User($poll["idusuarios"],$poll["nombre"],$poll["apellidos"]), $poll["titulo"], $poll["fecha_creacion"], $num));
		}

		return $polls;
	}

	public function get($id){
		$stmt = $this->db->prepare("SELECT titulo,usuarios_idcreador, fecha_inicio, fecha_fin, nombre, estado FROM encuestas,huecos, huecos_has_usuarios, usuarios WHERE huecos.encuestas_idencuestas = ? AND huecos.idhueco = huecos_has_usuarios.idhuecos AND usuarios.idusuarios = huecos_has_usuarios.usuarios_idusuarios and encuestas.idencuestas= ? ORDER by apellidos");
		$stmt->execute(array($id,$id));
		$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $poll_db;
	}

	

	public function save(Encuesta $encuesta) {
		$stmt = $this->db->prepare("INSERT INTO encuestas(usuarios_idcreador, titulo, fecha_creacion) values (?,?,?)");
		$stmt->execute(array($encuesta->getUsuarios_idcreador(), $encuesta->getTitulo(), $encuesta->getFechaCreacion()));
		return $this->db->lastInsertId();
	}
}
