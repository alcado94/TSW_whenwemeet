<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Encuesta.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/PollMapper.php");
require_once(__DIR__."/../model/HuecoMapper.php");
require_once(__DIR__."/../model/Huecos_has_usuariosMapper.php");

require_once(__DIR__."/../controller/BaseController.php");

/**
* Class UsersController
*
* Controller to login, logout and user registration
*
* @author lipido <lipido@gmail.com>
*/
class PollController extends BaseController {

	/**
	* Reference to the UserMapper to interact
	* with the database
	*
	* @var UserMapper
	*/
	private $userMapper;
	private $pollMapper;
	private $huecoMapper;
	private $huecohasusuariosMapper;

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();
		$this->pollMapper = new PollMapper();
		$this->huecoMapper = new HuecoMapper();
		$this->huecohasusuariosMapper = new HuecohasUsuariosMapper();


		// Users controller operates in a "welcome" layout
		// different to the "default" layout where the internal
		// menu is displayed
		$this->view->setLayout("welcome");
	}

	/**
	* Action to login
	*
	* Logins a user checking its creedentials agains
	* the database
	*
	* When called via GET, it shows the login form
	* When called via POST, it tries to login
	*
	* The expected HTTP parameters are:
	* <ul>
	* <li>login: The username (via HTTP POST)</li>
	* <li>passwd: The password (via HTTP POST)</li>
	* </ul>
	*
	* The views are:
	* <ul>
	* <li>posts/login: If this action is reached via HTTP GET (via include)</li>
	* <li>posts/index: If login succeds (via redirect)</li>
	* <li>users/login: If validation fails (via include). Includes these view variables:</li>
	* <ul>
	*	<li>errors: Array including validation errors</li>
	* </ul>
	* </ul>
	*
	* @return void
	*/

	public function index() {
		if (!isset($this->currentUser)) {
			$this->view->redirect("users","login");
		}

		$polls = $this->pollMapper->findall($_SESSION["currentuser"]);

		$imgs = $this->userMapper->findUserImgsbyPoll();
		
		// put the Post object to the view
		$this->view->setVariable("polls", $polls);
		$this->view->setVariable("imgs", $imgs);
		$this->view->setVariable("currentusername", $_SESSION["currentusername"]);

		$this->view->render("layouts", "dashboard");
	}

	// public function listpoll() {
		// $this->view->render("layouts", "dashboard");
	// }

	// public function getPoll() {
		// $result = $this->pollMapper->get(1);
		// print_r($result);
		// $this->view->render("layouts", "verTabla");
	// }

	public function add(){
		if (!isset($this->currentUser)) {
			$this->view->redirect("users","login");
		}

		if (isset($_POST["title"])){ 
		
			if($_POST["title"] == ''){
				throw new Exception("No tiene titulo");
			}

			$date = date("Y-m-d H:i:s");

			$enc = new Encuesta(NULL,$_SESSION["currentuser"],$_POST["title"],$date);
			$id_enc = $this->pollMapper->save($enc);

			foreach ($_POST["day"] as $key => $value) {
				
				$dia = $value[0];

				foreach ($value as $key2 => $value2) {
					
					if($value2 != $value[0] & !empty($value2['hourInit']) & !empty($value2['hourEnd']) & ($value2['hourInit'] < $value2['hourEnd'])){
						$hueco = new Hueco(NULL,$id_enc,$dia.' '.$value2['hourInit'],$dia.' '.$value2['hourEnd']);
						$this->huecoMapper->save($hueco);
					}
				}
			}
			$this->huecohasusuariosMapper->createHuecosUser($id_enc);

			$_SESSION["redir"] = strtotime($date).$id_enc;
			$this->view->redirect("poll","find");
		}

		$this->view->render("layouts", "addpoll");
	}

	public function edit(){
		
		if (!isset($this->currentUser)) {
			$this->view->redirect("users","login");
		}
		
		if(isset($_REQUEST["id"]) && !$this->pollMapper->userIsAuthor($_REQUEST["id"])){
			throw new Exception("No tienes permiso para editar esta encuesta");
		}

		$id = $_REQUEST["id"];
		
		$result = $this->recomposeArrayShowEditPoll($this->pollMapper->getEncuestaEdit($id,NULL));

		$this->view->setVariable("poll", $result);

		if (isset($_POST["title"])){ 
		
			$date = date("Y-m-d H:i:s");

			$enc = new Encuesta($id,$_SESSION["currentuser"],$_POST["title"],$date);
			$id_enc = $this->pollMapper->edit($enc);

			
			//HACE EL BORRADO
			//FUNCIONA NO TOCAR
			foreach ($result['diasId'] as $key2 => $value2) {	
				foreach ($value2 as $e) {
					$delete = True;
					
					foreach ($_POST['dayExist'] as $key => $value) {
						if($key == $e){
							$delete = False;
						}	
					}	

					if($delete & $this->huecoMapper->ownerHueco($e,$_SESSION["currentuser"])){
						$this->huecoMapper->delete($e);
					}
				}
						
			}
			
			if(isset($_POST["day"])){
				foreach ($_POST["day"] as $key => $value) {
				
					$dia = $value[0];

					foreach ($value as $key2 => $value2) {
						
						if($value2 != $value[0] & !empty($value2['hourInit']) & !empty($value2['hourEnd']) & ($value2['hourInit'] < $value2['hourEnd'])){
							$hueco = new Hueco(NULL,$id,$dia.' '.$value2['hourInit'],$dia.' '.$value2['hourEnd']);
							
							$idhueco = $this->huecoMapper->save($hueco);
						}
					}
				}
				$this->huecohasusuariosMapper->createHuecosUserSingle($idhueco,$id);
				
			}

			if(isset($_POST["dayNew"])){
				foreach ($_POST["dayNew"] as $key => $value) {
				
					$dia = $key;

					foreach ($value as $key2 => $value2) {
						
						if($value2 != $value[0] & !empty($value2['hourInit']) & !empty($value2['hourEnd']) & ($value2['hourInit'] < $value2['hourEnd'])){
							$hueco = new Hueco(NULL,$id,$dia.' '.$value2['hourInit'],$dia.' '.$value2['hourEnd']);
							
							$idhueco = $this->huecoMapper->save($hueco);
						}
					}
				}
				$this->huecohasusuariosMapper->createHuecosUserSingle($idhueco,$id);
				
			}

			$this->view->redirect("poll","index");
		}

		$this->view->render("layouts", "editpoll");
	}



	public function find(){
		
		if (!isset($this->currentUser)) {
			if(isset($_REQUEST["poll"])){
				$_SESSION["redir"]=$_REQUEST["poll"];
			}
			$this->view->redirect("users","login");
		}
		
		if(isset($_REQUEST["id"]) && !$this->huecohasusuariosMapper->existHuecoId($_REQUEST["id"]) && !$this->pollMapper->userIsAuthor($_REQUEST["id"])){
			throw new Exception("No tienes permiso para ver esta encuesta");
		}
		
		
		if(!isset($_REQUEST["id"]) && (isset($_REQUEST["poll"]) || (isset($_SESSION["redir"]) && $_SESSION["redir"]!=""))){
			if(isset($_REQUEST["poll"])){
				$poll = $_REQUEST["poll"];		
			}
			else{
				$poll = $_SESSION["redir"];

			}
			$id = substr($poll, 10);
			$time = substr($poll,0, 10);
			$date = date("Y-m-d H:i:s",$time);			
			
			$_SESSION["redir"]="";
		}
		else{
			$id = $_REQUEST["id"];
			$date=null;
		}
		

		$result = $this->pollMapper->get($id,$date);
		if(empty($result)){
			$result = $this->pollMapper->getEncuesta($id,$date);
		}
		if(empty($result)){
			$result = $this->pollMapper->getEncuestaInfo($id,$date);
		}
		if(!empty($result)){
			$_SESSION["permission"]=true;
			
			$author = $this->pollMapper->getAuthor($id);

			$toret = $this->recomposeArrayShow($result,$author->getName(),$_SESSION['currentuser']);

			$this->view->setVariable("poll", $toret);

			$this->view->render("layouts", "verTabla");
		}
		else{
			throw new Exception("La encuesta solicitada no existe en el sistema");
		}
	}
	
	
	
	public function participatePoll(){

		if (!isset($this->currentUser)) {
			if(isset($_REQUEST["poll"])){
				$_SESSION["redir"]=$_REQUEST["poll"];
			}
			$this->view->redirect("users","login");
		}
		
		if(!$_SESSION["permission"] && !isset($_REQUEST["show"])){
			throw new Exception("No tienes permiso para ver esta encuesta");
		}
		
		$_SESSION["permission"]=false;

		$id = $_REQUEST["id"];

		if( isset($_REQUEST["show"]) ) {
			
			$user = new User($_SESSION['currentuser']);

			if(isset($_POST["participateDate"])){
				foreach ($_POST["participateDate"] as $key => $value) {
				
					$hueco_part = new Hueco_has_usuarios($key,$user,NULL);

					if(!$this->huecohasusuariosMapper->existHueco($hueco_part)){
						print_r("no es tu hueco");
					}
				}
			}

			$huecos = $this->huecoMapper->getAllOneEncuesta($id);
			
			foreach ($huecos as $hueco) {
				$this->huecohasusuariosMapper->defaultAllHueco($user,$hueco);
			}
		

			if(isset($_POST["participateDate"])){
				foreach ($_POST["participateDate"] as $key => $value) {

					$hueco_part = new Hueco_has_usuarios($key,$user,1);

					$this->huecohasusuariosMapper->modify($hueco_part);
					
				}
			}
			

			$this->view->redirect("poll","index");

		}	
		
		if(!$this->huecohasusuariosMapper->existHuecoId($id)){
			$this->huecohasusuariosMapper->createHuecosUser($id);
		}

		$result = $this->pollMapper->get($id,NULL);
		if(empty($result)){
			$result = $this->pollMapper->getEncuesta($id);
		}
		if(empty($result)){
			$result = $this->pollMapper->getEncuestaInfo($id);
		}
		$author = $this->pollMapper->getAuthor($id);

		$toret = $this->recomposeArrayShow($result,$author->getName(),$_SESSION['currentuser']);

		$this->view->setVariable("poll", $toret);
		
		$this->view->render("layouts", "participarEncuesta");
	
	}


	private function recomposeArrayShowEditPoll($poll_db){

		$result = array();
		$result['title'] = $poll_db[0]['titulo'];
		$result['Id'] = $poll_db[0]['idencuestas'];
		$result['dias'] = array();
		$result['diasId'] = array();

		foreach ($poll_db as $value) {
			$parts = explode(' ', $value['fecha_inicio']);
			$parts2 = explode(' ', $value['fecha_fin']);
			
			$result['dias'][$parts[0]] = array();
			
		}
		foreach($poll_db as $poll){
			$parts = explode(' ', $poll['fecha_inicio']);
			$parts2 = explode(' ', $poll['fecha_fin']);
			if(isset($result['dias'][$parts[0]])){
				array_push($result['dias'][$parts[0]],array("Init"=>$parts[1],"End"=>$parts2[1]));
			}
		}


		foreach ($poll_db as $value) {
			$parts = explode(' ', $value['fecha_inicio']);
			$parts2 = explode(' ', $value['fecha_fin']);
			
			$result['diasId'][$parts[0]] = array();
			
		}
		foreach($poll_db as $poll){
			$parts = explode(' ', $poll['fecha_inicio']);
			$parts2 = explode(' ', $poll['fecha_fin']);
			if(isset($result['diasId'][$parts[0]])){
				array_push($result['diasId'][$parts[0]],$poll['idhueco']);
			}
		}
		return $result;
	}

	public function recomposeArrayShow($result, $autor, $iduser){

		if ($result instanceof Encuesta){
			$toret = array();
			$toret['id'] = $result->getId();
			$toret['titulo'] = $result->getTitulo();
			$toret['autor'] = $autor;
			$toret['idAutor'] = $result->getFechaCreacion();
			$toret['participantes'] = array();
			$toret['participantesId'] = array();
			$toret['participantesImg'] = array();
			$toret['dias'] = array();
			$toret['url'] = strtotime($result->getFechaCreacion()).$result->getId();;

			$toret['diasId'] = array();

			return $toret;
		}


		if(isset($result[0]['fecha_inicio']) & isset($result[0]['idusuarios'])){

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
		$toret['idAutor'] = $result[0]['usuarios_idcreador'];
		$toret['participantes'] = array();
		$toret['participantesId'] = array();
		$toret['participantesImg'] = array();
		$toret['dias'] = array();
		$toret['url'] = strtotime($result[0]['fecha_creacion']).$result[0]['idencuestas'];

		$toret['diasId'] = array();

		$i = 0;
		if(isset($result[0]['fecha_inicio'])){

			if(isset($result[0]['nombre'])){
				$toret['participantes'][$i] = $result[0]['nombre'];
				$toret['participantesId'][$i] = $result[0]['idusuarios'];
				$toret['participantesImg'][$i] = $result[0]['img'];
			}

			$parts = explode(' ', $result[0]['fecha_inicio']);
			
			$toret['dias'][$parts[0]] = array();

			$i++;
			
			
			foreach ($result as $key => $value) {
				foreach($toret['participantes'] as $k=>$val){
					
					if(!in_array($value['nombre'], $toret['participantes'])){
						$toret['participantes'][$i] = $value['nombre'];
						$toret['participantesId'][$i] = $value['idusuarios'];
						$toret['participantesImg'][$i] = $value['img'];
						
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
			foreach ($result as $key => $value) {
				$parts = explode(' ', $value['fecha_inicio']);
				$partsfin = explode(' ', $value['fecha_fin']);
				if(isset($value['estado']))
					array_push($toret['dias'][$parts[0]][$parts[1].'-'.$partsfin[1]],$value['estado']);
				else
					array_push($toret['dias'][$parts[0]][$parts[1].'-'.$partsfin[1]],'');
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
