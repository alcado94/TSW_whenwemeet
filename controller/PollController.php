<?php

require_once(__DIR__."/../core/ViewManager.php");
require_once(__DIR__."/../core/I18n.php");

require_once(__DIR__."/../model/User.php");
require_once(__DIR__."/../model/Encuesta.php");
require_once(__DIR__."/../model/UserMapper.php");
require_once(__DIR__."/../model/PollMapper.php");

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

	public function __construct() {
		parent::__construct();

		$this->userMapper = new UserMapper();
		$this->pollMapper = new PollMapper();

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

		$polls = $this->pollMapper->findall($_SESSION["currentuser"]);

		
		// put the Post object to the view
		$this->view->setVariable("polls", $polls);
		$this->view->setVariable("currentusername", $_SESSION["currentusername"]);

		$this->view->render("layouts", "dashboard");
	}

	public function listpoll() {
		/*if (isset($_POST["username"])){ // reaching via HTTP Post...
			//process login form
			if ($this->userMapper->isValidUser($_POST["username"], 							 $_POST["passwd"])) {

				$_SESSION["currentuser"]=$_POST["username"];

				// send user to the restricted area (HTTP 302 code)
				$this->view->redirect("posts", "index");

			}else{
				$errors = array();
				$errors["general"] = "Username is not valid";
				$this->view->setVariable("errors", $errors);
			}
		}*/

		// render the view (/view/users/login.php)
		//$this->view->render("layout", "dashboard");
		$this->view->render("layouts", "dashboard");
	}

	public function add(){
		$this->view->render("layouts", "addpoll");
	}

	public function find(){
		$this->view->render("layouts", "verTabla");
	}
	

}
