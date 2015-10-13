<?php

require_once("XmlDataAccess.php");

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
}

class ContactFactory
{
    public static function create()
    {
        return new Contact();
    }
}

?>