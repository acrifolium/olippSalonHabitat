<?php

require_once("XmlDataAccess.php");
require_once("Mailer.php");

class Contact extends XmlDataAccess {

	public function __construct()
    {
    	parent::__construct();
    }

	public function GetContact()
	{
		$response = array();

		if(is_null($this->GetXmlRootConfig())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - Config's data are not accessible!";
	        return $response;
		}

		$response["headquarter"] = (string)$this->GetXmlRootConfig()->contact->headquarter;

		$address = array();
		$address["firstLine"] = (string)$this->GetXmlRootConfig()->contact->address->firstLine;
		$address["secondLine"] = (string)$this->GetXmlRootConfig()->contact->address->secondLine;
		$address["postalCode"] = (string)$this->GetXmlRootConfig()->contact->address->postalCode;
		$address["city"] = (string)$this->GetXmlRootConfig()->contact->address->city;
		$response["address"] = $address;

		$response["site"] = (string)$this->GetXmlRootConfig()->contact->site;
		$response["mail"] = (string)$this->GetXmlRootConfig()->contact->mail;

		foreach($this->GetXmlRootConfig()->contact->members->children() as $member)
		{
			$node = array('name' => (string)$member->name,
						  'telephone' => (string)$member->telephone);

			$response["members"][] = $node;
		}

		return $response;
	}

	public function GetContactForm($id)
	{
		$response = array();

		if(is_null($this->GetXmlRootContact())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - Contact's data are not accessible!";
	        return $response;
		}

		if (isset($this->GetXmlRootContact()->contact['id']) && $this->GetXmlRootContact()->contact['id'] == $id)
		{

			$response["fieldLastname"] = (string)$this->GetXmlRootContact()->contact->form->fieldLastname;
			$response["requiredFieldLastname"] = (string)$this->GetXmlRootContact()->contact->form->requiredFieldLastname;
			$response["fieldFirstname"] = (string)$this->GetXmlRootContact()->contact->form->fieldFirstname;
			$response["requiredFieldFirstname"] = (string)$this->GetXmlRootContact()->contact->form->requiredFieldFirstname;
			$response["fieldEmail"] = (string)$this->GetXmlRootContact()->contact->form->fieldEmail;
			$response["requiredFieldEmail"] = (string)$this->GetXmlRootContact()->contact->form->requiredFieldEmail;
			$response["validFieldEmail"] = (string)$this->GetXmlRootContact()->contact->form->validFieldEmail;
			$response["fieldCompany"] = (string)$this->GetXmlRootContact()->contact->form->fieldCompany;
			$response["fieldPhone"] = (string)$this->GetXmlRootContact()->contact->form->fieldPhone;
			$response["fieldMessage"] = (string)$this->GetXmlRootContact()->contact->form->fieldMessage;
			$response["button"] = (string)$this->GetXmlRootContact()->contact->form->button;
			$response["panelTitle1"] = (string)$this->GetXmlRootContact()->contact->panelTitle1;
		}
		else 
		{
            $response['status'] = "error";
            $response['message'] = 'No such contact elements have been stored';
        }

		return $response;
	}

	public function SendMail($lastname, $firstname, $email, $company, $telephone, $message)
	{
		$response = array();

		if(is_null($this->GetXmlRootConfig())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - Config's data are not accessible!";
	        return $response;
		}

      	$content = "Nom: " .$lastname;
      	$content .= "<br>Prénom: " .$firstname;
      	$content .= "<br>Email: " .$email;
      	$content .= "<br>Société: " .$company;
      	$content .= "<br>Téléphone: " .$telephone;
      	$content .= "<br>Message: " .$message;

		$mailer = MailerFactory::create();
		if($mailer->SendMail("ContactForm", $email, $content)){

			$response["status"] = "success";
		    $response["message"] = "L'Email a bien été envoyé.";
		}
		else{
			$response["status"] = "error";
		    $response["message"] = "L'envoie de l'Email est impossible.";
		}

		return $response;
	}
}

class ContactFactory
{
    public static function create()
    {
        return new Contact();
    }
}

?>