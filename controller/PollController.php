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

	public function listpoll() {
		$this->view->render("layouts", "dashboard");
	}

	public function getPoll() {
		$result = $this->pollMapper->get(1);
		print_r($result);
		$this->view->render("layouts", "verTabla");
	}

	public function add(){
		if (!isset($this->currentUser)) {
			$this->view->redirect("users","login");
		}

		if (isset($_POST["title"])){ 
		
			if($_POST["title"] == ''){
				print_r("Sin titulo");
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

		$id = $_REQUEST["id"];
		
		$result = $this->pollMapper->getEncuestaEdit($id,NULL);

		$this->view->setVariable("poll", $result);

		if (isset($_POST["title"])){ 
		
			$date = date("Y-m-d H:i:s");

			$enc = new Encuesta($id,$_SESSION["currentuser"],$_POST["title"],$date);
			$id_enc = $this->pollMapper->edit($enc);



			/*
			if(isset($_POST["day"])){
				foreach ($_POST["day"] as $key => $value) {
					foreach ($_POST["day"] as $key2 => $value2) {
						if($value == $value2 & $key!=$key2){
							print_r("Fuera!!!!!");
						}
					}	
					
					foreach ($value as $key2 => $value2) {
						print_r($value2);
						if(isset($value2['hourInit']) & $value2['hourInit'] >= $value2['hourEnd']){
							print_r("Fuera!!!!!");
						}
						foreach ($value as $key3 => $value3) {
							if(($value2['hourInit'] > $value3['hourInit'] & $value2['hourInit'] < $value3['hourEnd'])
								| ($value2['hourEnd'] > $value3['hourInit'] & $value2['hourEnd'] < $value3['hourEnd']) ){
									print_r("Fueraaa!!!");
							}
						}
					}

				}	
			}
			*/


			
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
				$this->huecohasusuariosMapper->createHuecosUserSingle($idhueco);
				
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
				$this->huecohasusuariosMapper->createHuecosUserSingle($idhueco);
				
			}

			//$this->view->redirect("poll", "index");
			#$_SESSION["redir"] = strtotime($date).$id_enc;
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
		
		// if((isset($_REQUEST["id"]) && !$this->huecohasusuariosMapper->existHuecoId($_REQUEST["id"])) || (isset($_REQUEST["id"]) && !$this->pollMapper->userIsAuthor($_REQUEST["id"]))){
			// throw new Exception("No tienes permiso para ver esta encuesta");
		// }
		
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

			$toret = $this->pollMapper->recomposeArrayShow($result,$author[0]['nombre'],$_SESSION['currentuser']);

			$this->view->setVariable("poll", $toret);

			$this->view->render("layouts", "verTabla");
		}
		else{
			throw new Exception("La encuesta solicitada no existe en el sistema");
		}
	}
	
	public function participate(){
		if (!isset($this->currentUser)) {
			$this->view->redirect("users","login");
		}
		//Recojer el id real a partir de la combinacion de la url
		$poll = $_REQUEST["poll"];		
		$id =substr($poll, 10);
		
		$result = $this->pollMapper->get($id,NULL);
		if(empty($result)){
			$result = $this->pollMapper->getEncuesta($id);
		}
		if(empty($result)){
			$result = $this->pollMapper->getEncuestaInfo($id);
		}
		$author = $this->pollMapper->getAuthor($id);

		$toret = $this->pollMapper->recomposeArrayShow($result,$author[0]['nombre'],$_SESSION['currentuser']);

		$this->view->setVariable("poll", $toret);

		$this->view->render("layouts", "verTabla");
		
	
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

		$toret = $this->pollMapper->recomposeArrayShow($result,$author[0]['nombre'],$_SESSION['currentuser']);

		$this->view->setVariable("poll", $toret);
		
		$this->view->render("layouts", "participarEncuesta");
	
	}

}
