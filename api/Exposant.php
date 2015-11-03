<?php

require_once("XmlDataAccess.php");

class Exposant extends XmlDataAccess {

	public function __construct()
    {
    	parent::__construct();
    }

	public function GetExposant()
	{
		$response = array();

		if(is_null($this->GetXmlRootExposant())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - Exposant's data are not accessible!";
	        return $response;
		}

		foreach($this->GetXmlRootExposant()->children() as $exposant)
		{
			$node = array();

			$node["name"] = (string)$exposant->name;
			$node["type"] = (string)$exposant->type;
			$node["description"] = (string)$exposant->description;

			$address = array();
			$address["firstLine"] = (string)$exposant->address->firstLine;
			$address["secondLine"] = (string)$exposant->address->secondLine;
			$address["postalCode"] = (string)$exposant->address->postalCode;
			$address["city"] = (string)$exposant->address->city;
			$node["address"] = $address;

			$node["webSite"] = (string)$exposant->webSite;
			$node["telephone"] = (string)$exposant->telephone;
			$node["portable"] = (string)$exposant->portable;
			$node["fax"] = (string)$exposant->fax;
			$node["mail"] = (string)$exposant->mail;

			$response[] = $node;
		}
		return $response;
	}

	public function GetExposantForm($id)
	{
		$response = array();

		if(is_null($this->GetXmlRootService())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - Service's data are not accessible!";
	        return $response;
		}

		if (isset($this->GetXmlRootService()->service['id']) && $this->GetXmlRootService()->service['id'] == $id)
		{
			$response["panelTitleCenter"] = (string)$this->GetXmlRootService()->service->panelTitleCenter;
			$response["labelSearchToolbar"] = (string)$this->GetXmlRootService()->service->labelSearchToolbar;
			$response["panelRightTitle"] = (string)$this->GetXmlRootService()->service->panelRightTitle;
			$response["panelRightLabelDownload"] = (string)$this->GetXmlRootService()->service->panelRightLabelDownload;
			$response["panelRightDescription"] = (string)$this->GetXmlRootService()->service->panelRightDescription;
		}
		else 
		{
            $response['status'] = "error";
            $response['message'] = 'No such Services exposant have been stored';
        }

		return $response;		
	}
}

class ExposantFactory
{
    public static function create()
    {
        return new Exposant();
    }
}

?>