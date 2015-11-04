<?php

require_once("XmlDataAccess.php");

class Mailer extends XmlDataAccess {

	private $mailFrom;

	public function __construct()
    {
    	parent::__construct();

    	$this->mailFrom = $this->GetXmlRootConfig()->contact->mail;
    }

    public function SendMail($type, $to, $content){

    	switch ($type) {

    		case "ContactForm":

    			$subject = "Site Web Salon Tout Pour L'Habitat";
				$body = "<html>";
				$body .= "<head>";
				$body .= "<title>Salon Tout pour l'Habitat</title>";
				$body .= "</head>";
				$body .= "<body>";
				$body .= "<h1>Site Web Salon Tout Pour L'Habitat</h1>";
				$body .= "<h3>" . $content . "</h3>";
				$body .= "</body>";
				$body .= "</html>";

				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= "From: <".$this->mailFrom.">" . "\r\n";

				return mail($to, $subject, $body, $headers);

    			break;
    		case "RecoverPassword":

				$subject = "Olipp Recover password";
				$body = "<html>";
				$body .= "<head>";
				$body .= "<title>Olipp Recover password</title>";
				$body .= "</head>";
				$body .= "<body>";
				$body .= "<h1>Olipp Recover Password</h1>";
				$body .= "<h3>" . $content . "</h3>";
				$body .= "</body>";
				$body .= "</html>";

				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				$headers .= 'From: <olipp@olipp.com>' . "\r\n";
				// $headers .= 'Cc: myboss@example.com' . "\r\n";

				// $smtp = Mail::factory('smtp',
				//    		array ('host' => $this->host,
				// 	     	   'auth' => true,
				// 	     	   'username' => $this->smtp_username,
				// 	     	   'password' => $this->smtp_password));

	 			return mail($to, $subject, $body, $headers);

    			break;
    		case "CheckEmail":
    		default:
    			# code...
    			break;
    		}

    	return false;
    }
}

class MailerFactory
{
    public static function create()
    {
        return new Mailer();
    }
}
?>