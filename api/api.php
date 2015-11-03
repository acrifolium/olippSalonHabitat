<?php
 	require_once("libs/Rest.inc.php");	
	require_once("Navigation.php");
	require_once("Dashboard.php");
	require_once("Contact.php");
	require_once("Exposant.php");
	require_once("Movie.php");
	require_once("Contact.php");
	require_once("Authentication.php");

	class API extends REST {
	
		public $data = "";

		public function __construct(){
			parent::__construct();				// Init parent contructor
		}
		
		/*
		 * Dynmically call the method based on the query string
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['x'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404); // If the method not exist with in this class "Page not found".
		}
		
		private function navigation(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$nav = NavigationFactory::create();
			if(is_null($nav))
				$this->response('',406);
			else
				$this->response($this->json($nav->GetNavigation()), 200);
		}

		private function config(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$cont = ContactFactory::create();
			if(is_null($cont))
				$this->response('',406);
			else
				$this->response($this->json($cont->GetContact()), 200);
		}

		private function dashboard(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$dash = DashboardFactory::create();
			if(is_null($dash))
				$this->response('',406);
			else
				$this->response($this->json($dash->GetDashboard()), 200);
		}

		private function exposant(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$exp = ExposantFactory::create();
			if(is_null($exp))
				$this->response('',406);
			else
				$this->response($this->json($exp->GetExposant()), 200);
		}

		private function contact(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$data = json_decode(file_get_contents("php://input"),true);
			$id = $data['id'];

			$cont = ContactFactory::create();
			if(is_null($cont))
				$this->response('',406);
			else
				$this->response($this->json($cont->GetContactForm($id)), 200);
		}

		private function movies(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$data = json_decode(file_get_contents("php://input"),true);
			$id = $data['id'];

			$mov = MovieFactory::create();
			if(is_null($mov))
				$this->response('',406);
			else
				$this->response($this->json($mov->GetMovies($id)), 200);
		}

		private function sendMail(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$data = json_decode(file_get_contents("php://input"),true);
			$lastname = $data['lastname'];
			$firstname = $data['firstname'];
			$email = $data['email'];
			$company = $data['company'];
			$telephone = $data['telephone'];
			$message = $data['message'];

			$func = ContactFactory::create();
			if(is_null($func))
				$this->response('',406);
			else{
				$result = $func->SendMail($lastname, $firstname, $email, $company, $telephone, $message);

				if($result['status'] == "success")
					$this->response($this->json($result), 200);
				else $this->response($this->json($result), 406);
			}
		}

		private function session(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$func = AuthenticationFactory::create();
			if(is_null($func))
				$this->response('',406);
			else
				$this->response($this->json($func->GetSession()), 200);
		}

		private function logout(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$func = AuthenticationFactory::create();
			if(is_null($func))
				$this->response('',406);
			else
				$this->response($this->json($func->DestroySession()), 200);
		}

		private function IsAdminExists(){
			if($this->get_request_method() != "GET"){
				$this->response('',406);
			}

			$func = AuthenticationFactory::create();
			if(is_null($func))
				$this->response('',406);
			else
				$this->response($this->json($func->IsAdminExists()), 200);			
		}	
		
		private function signUpAdmin(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$data = json_decode(file_get_contents("php://input"),true);
			$username = $data['username'];
			$email = $data['email'];
			$password = $data['password'];

			$func = AuthenticationFactory::create();
			if(is_null($func))
				$this->response('',406);
			else{
				$result = $func->SignUpAdmin($username, $email, $password);

				if($result['status'] == "success")
					$this->response($this->json($result), 200);
				else $this->response($this->json($result), 406);
			}
		}

		private function login(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$data = json_decode(file_get_contents("php://input"),true);
			$username = $data['username'];
			$password = $data['password'];

			$func = AuthenticationFactory::create();
			if(is_null($func))
				$this->response('',406);
			else{
				$result = $func->Login($username, $password);

				if($result['status'] == "success")
					$this->response($this->json($result), 200);
				else $this->response($this->json($result), 406);
			}
		}

		private function recoverAccount(){
			if($this->get_request_method() != "POST"){
				$this->response('',406);
			}

			$data = json_decode(file_get_contents("php://input"),true);
			$email = $data['email'];

			$func = AuthenticationFactory::create();
			if(is_null($func))
				$this->response('',406);
			else{
				$result = $func->RecoverAccount($email);
				
				if($result['status'] == "success")
					$this->response($this->json($result), 200);
				else $this->response($this->json($result), 406);
			}
		}
		/*
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data, JSON_UNESCAPED_UNICODE);
			}
		}
	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();
?>