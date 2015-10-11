<?php

require_once("XmlDataAccess.php");
require_once("Mailer.php");

class Authentication extends XmlDataAccess {

	public function __construct()
    {
    	parent::__construct();
    }

	public function getSession(){
	    if (!isset($_SESSION)) {
	        session_start();
	    }
	    $sess = array();
	    if(isset($_SESSION['guid']))
	    {
	        $sess["guid"] = $_SESSION['guid'];
	        $sess["username"] = $_SESSION['username'];
	        $sess["email"] = $_SESSION['email'];
	    }
	    else
	    {
	        $sess["guid"] = '';
	        $sess["username"] = 'Guest';
	        $sess["email"] = '';
	    }
	    return $sess;
	}

	public function DestroySession(){
		$response = array();

	    if (!isset($_SESSION)) {
	    	session_start();
	    }
	    if(isSet($_SESSION['guid']))
	    {
	        unset($_SESSION['guid']);
	        unset($_SESSION['username']);
	        unset($_SESSION['email']);

	        $info='info';
	        if(isSet($_COOKIE[$info]))
	        {
	            setcookie ($info, '', time() - $cookie_time);
	        }

	        $response["status"] = "info";
    		$response["message"] = "Logged out successfully";
	    }
	    else
	    {
	        $response["status"] = "info";
    		$response["message"] = "Not logged in...";
	    }
	    return $response;
	}

	private function GUID(){
	    if (function_exists('com_create_guid') === true)
	    {
	        return trim(com_create_guid(), '{}');
	    }

	    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}

	private function random_password( $length = 8 ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}

	public function IsAdminExists(){

		$response = array();

		if(is_null($this->GetXmlRootUsers())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - User's data are not accessible!";
	        return $response;
		}

		if (property_exists($this->GetXmlRootUsers()->users, 'admin')) 
			$response['value'] = true;
		else $response['value'] = false;
			
		return $response;	
	}

	public function SignUpAdmin($username, $email, $password){
		$response = array();

		$rootUsers = $this->GetXmlRootUsers();

		if(is_null($rootUsers)){
			$response["status"] = "error";
	        $response["message"] = "Technical error - User's data are not accessible!";
	        return $response;
		}

		if (!property_exists($rootUsers->users, 'admin'))
		{
			$admin = $rootUsers->users->addChild('admin');
			$admin->addChild('guid',$this->GUID());
			$admin->addChild('username',$username);
			$admin->addChild('email',$email);
			$admin->addChild('password',md5($password));

			$rootUsers->asXml($this->GetXmlFileUsers());

			$response["status"] = "success";
            $response["message"] = "User Admin account created successfully";
            $response["guid"] = (string)$this->GetXmlRootUsers()->users->admin->guid;
            $response['username'] = (string)$this->GetXmlRootUsers()->users->admin->username;
            $response['email'] = (string)$this->GetXmlRootUsers()->users->admin->email;

            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['guid'] = (string)$this->GetXmlRootUsers()->users->admin->guid;
            $_SESSION['username'] = (string)$this->GetXmlRootUsers()->users->admin->username;
            $_SESSION['email'] = (string)$this->GetXmlRootUsers()->users->admin->email;
		}
		else
		{
	        $response["status"] = "error";
	        $response["message"] = "An user with the provided email exists!";
		}

		return $response;
	}

	public function Login($username, $password){
		$response = array();

		if(is_null($this->GetXmlRootUsers())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - User's data are not accessible!";
	        return $response;
		}

		if (property_exists($this->GetXmlRootUsers()->users, 'admin'))
		{
			if ($this->GetXmlRootUsers()->users->admin->username == $username &&
				$this->GetXmlRootUsers()->users->admin->password == md5($password))
			{
				$guid = (string)$this->GetXmlRootUsers()->users->admin->guid;				
				$email = (string)$this->GetXmlRootUsers()->users->admin->email;

		        $response['status'] = "success";
		        $response['message'] = 'Logged in successfully.';
		        $response['username'] = $username;
		        $response['guid'] = $guid;
		        $response['email'] = $email;

				if (!isset($_SESSION)) {
		            session_start();
		        }
		        $_SESSION['guid'] = $guid;
		        $_SESSION['email'] = $email;
		        $_SESSION['username'] = $username;
			}
			else 
			{
            	$response['status'] = "error";
            	$response['message'] = 'Login failed. Incorrect credentials';
            }	
		}
		else 
		{
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }

		return $response;
	}

	public function RecoverAccount($email){
		$response = array();

		$rootUsers = $this->GetXmlRootUsers();

		if(is_null($rootUsers)){
			$response["status"] = "error";
	        $response["message"] = "Technical error - User's data are not accessible!";
	        return $response;
		}

		if (property_exists($rootUsers->users, 'admin'))
		{
			if ($rootUsers->users->admin->email == $email)
			{
				$newPassword = $this->random_password();

				$content = "New Password: " . $newPassword;

				$mailer = MailerFactory::create();
				if($mailer->SendMail(MailTypeEnum::RecoverPassword, $email, $content)){

					$rootUsers->users->admin->password = md5($newPassword);
					$rootUsers->asXML($this->GetXmlFileUsers());

					$response["status"] = "success";
		        	$response["message"] = "A new password has been sent to your Mail box";
				}
				else{
					$response["status"] = "error";
		        	$response["message"] = "Impossible to send an email.";
				}
			}
			else 
			{
            	$response["status"] = "error";
            	$response["message"] = "Email incorrect.";
            }	
		}
		else 
		{
            $response["status"] = "error";
            $response["message"] = "No such user is registered";
        }

		return $response;
	}
}

class AuthenticationFactory
{
    public static function create()
    {
        return new Authentication();
    }
}

?>