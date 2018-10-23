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

	public function get($id, $date){
		if($date==null){
			$stmt = $this->db->prepare("SELECT idencuestas, titulo,fecha_creacion,idencuestas,usuarios_idcreador, fecha_inicio, fecha_fin, nombre, estado,idhuecos, idusuarios FROM encuestas,huecos, huecos_has_usuarios, usuarios 
				WHERE huecos.encuestas_idencuestas = ? AND huecos.idhueco = huecos_has_usuarios.idhuecos 
				AND usuarios.idusuarios = huecos_has_usuarios.usuarios_idusuarios AND encuestas.idencuestas= ? ORDER by fecha_inicio");
			$stmt->execute(array($id,$id));
			$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			$stmt = $this->db->prepare("SELECT idencuestas, titulo,fecha_creacion,idencuestas,usuarios_idcreador, fecha_inicio, fecha_fin, nombre, estado, idhuecos, idusuarios FROM encuestas,huecos, huecos_has_usuarios, usuarios 
			WHERE huecos.encuestas_idencuestas = ? AND huecos.idhueco = huecos_has_usuarios.idhuecos 
			AND usuarios.idusuarios = huecos_has_usuarios.usuarios_idusuarios AND encuestas.idencuestas= ? AND fecha_creacion = ? ORDER by fecha_inicio");
			$stmt->execute(array($id,$id,$date));
			$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		}

		return $poll_db;
	}

	public function getEncuesta($id, $date){
		if($date==null){
			$stmt = $this->db->prepare("SELECT titulo,fecha_creacion,idencuestas,usuarios_idcreador, fecha_inicio, fecha_fin FROM encuestas,huecos 
			WHERE huecos.encuestas_idencuestas = encuestas.idencuestas AND encuestas.idencuestas= ?");
			$stmt->execute(array($id));
			$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			$stmt = $this->db->prepare("SELECT titulo,fecha_creacion,idencuestas,usuarios_idcreador, fecha_inicio, fecha_fin FROM encuestas,huecos 
			WHERE huecos.encuestas_idencuestas = encuestas.idencuestas AND encuestas.idencuestas= ? AND fecha_creacion=?");
			$stmt->execute(array($id,$date));
			$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		return $poll_db;
	}

	
	public function getEncuestaInfo($id, $date){
		if($date==null){
			$stmt = $this->db->prepare("SELECT titulo,fecha_creacion,idencuestas,usuarios_idcreador FROM encuestas,huecos 
			WHERE encuestas.idencuestas= ?");
			$stmt->execute(array($id));
			$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else{
			$stmt = $this->db->prepare("SELECT titulo,fecha_creacion,idencuestas,usuarios_idcreador FROM encuestas,huecos 
			WHERE encuestas.idencuestas= ? AND fecha_creacion=?");
			$stmt->execute(array($id,$date));
			$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		}
		
		return $poll_db;
	}

	public function getAuthor($id){
		$stmt = $this->db->prepare("SELECT nombre FROM encuestas, usuarios WHERE  encuestas.usuarios_idcreador = usuarios.idusuarios and encuestas.idencuestas = ?");
		$stmt->execute(array($id));
		$poll_db = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $poll_db;
	}

	public function save(Encuesta $encuesta) {
		$stmt = $this->db->prepare("INSERT INTO encuestas(usuarios_idcreador, titulo, fecha_creacion) values (?,?,?)");
		$stmt->execute(array($encuesta->getUsuarios_idcreador(), $encuesta->getTitulo(), $encuesta->getFechaCreacion()));
		return $this->db->lastInsertId();
	}

	public function recomposeArrayShow($result, $autor){

		if(isset($result[0]['fecha_inicio'])){

			$iduser = 7;
			$checkDays =  array();
			$day;
			$daypos;

			foreach ($result as $key => $value) {
				if(!in_array($value['fecha_inicio'],$checkDays)){
					array_push($checkDays,$value['fecha_inicio']);
					$day = $value['fecha_inicio'];
					$daypos = $key;
					$temp = $value;
				}

				if($day == $value['fecha_inicio'] & $iduser == $value['idusuarios']){
					$result[$daypos] = $value;
					$result[$key] = $temp;
				}
			}
		}

		$toret = array();
		$toret['id'] = $result[0]['idencuestas'];
		$toret['titulo'] = $result[0]['titulo'];
		$toret['autor'] = $autor;
		$toret['participantes'] = array();
		$toret['participantesId'] = array();
		$toret['dias'] = array();
		$toret['url'] = strtotime($result[0]['fecha_creacion']).$result[0]['idencuestas'];

		$toret['diasId'] = array();

		$i = 0;
		if(isset($result[0]['fecha_inicio'])){

			if(isset($result[0]['nombre'])){
				$toret['participantes'][$i] = $result[0]['nombre'];
				$toret['participantesId'][$i] = $result[0]['idusuarios'];
			}

			$parts = explode(' ', $result[0]['fecha_inicio']);
			
			$toret['dias'][$parts[0]] = array();

			$i++;
		

			foreach ($result as $key => $value) {
				foreach($toret['participantes'] as $k=>$val){
					if(!in_array($value['nombre'], $toret['participantes'])){
						$toret['participantes'][$i] = $value['nombre'];
						$toret['participantesId'][$i] = $value['idusuarios'];
						
						$i++;
					}
				}	
			}

			$i = 0;
			foreach ($result as $key => $value) {
				foreach($toret['dias'] as $k=>$val){
					$parts = explode(' ', $value['fecha_inicio']);
					
					
					if(!in_array($parts[0], $toret['dias'])){
						$toret['dias'][$parts[0]] = array();	
					}

				}	
			}

			foreach ($result as $key => $value) {
				$parts = explode(' ', $value['fecha_inicio']);
				$partsfin = explode(' ', $value['fecha_fin']);
				foreach($toret['dias'] as $k2=>$val2){				
					$toret['dias'][$k2][$parts[1].'-'.$partsfin[1]] = array();	
				}
			}

			$i = 0;
			if(isset($result[0]['nombre'])){
				foreach ($result as $key => $value) {
					$parts = explode(' ', $value['fecha_inicio']);
					$partsfin = explode(' ', $value['fecha_fin']);
					array_push($toret['dias'][$parts[0]][$parts[1].'-'.$partsfin[1]],$value['estado']);
				}
			}

			foreach ($toret['dias'] as $key => $value) {
				foreach ($toret['dias'][$key] as $key2 => $value2) {
					if(empty($toret['dias'][$key][$key2])){
						unset($toret['dias'][$key][$key2]);
					}
			
				}
			}

			foreach ($result as $key => $value) {
				foreach($toret['participantes'] as $k=>$val){
					if(!in_array($value['idhuecos'], $toret['diasId'])){
						array_push($toret['diasId'],$value['idhuecos']);
						
					}
				}	
			}

			
		}

		return $toret;
	}
}
