<?php

require_once("XmlDataAccess.php");

class Dashboard extends XmlDataAccess {

	public function __construct()
    {
    	parent::__construct();
    }

	public function GetDashboard()
	{
		$response = array();

		if(is_null($this->GetXmlRootDashboard())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - Dashboard's data are not accessible!";
	        return $response;
		}

		$response["panelTitlePrincipal"] = (string)$this->GetXmlRootDashboard()->panelTitlePrincipal;
		$response["panelBodyTitle"] = (string)$this->GetXmlRootDashboard()->panelBodyTitle;
		$response["panelBodyDescription"] = (string)$this->GetXmlRootDashboard()->panelBodyDescription;
		$response["panelTitleRightFirst"] = (string)$this->GetXmlRootDashboard()->panelTitleRightFirst;
		$response["panelLabelRightFirst"] = (string)$this->GetXmlRootDashboard()->panelLabelRightFirst;
		$response["panelBodyRightFirst"] = (string)$this->GetXmlRootDashboard()->panelBodyRightFirst;
		$response["panelTitleRightSecond"] = (string)$this->GetXmlRootDashboard()->panelTitleRightSecond;
		$response["panelBodyRightSecondLine1"] = (string)$this->GetXmlRootDashboard()->panelBodyRightSecondLine1;
		$response["panelBodyRightSecondLine2"] = (string)$this->GetXmlRootDashboard()->panelBodyRightSecondLine2;
		$response["panelBodyRightSecondLine3"] = (string)$this->GetXmlRootDashboard()->panelBodyRightSecondLine3;
		$response["panelBodyRightSecondLine4"] = (string)$this->GetXmlRootDashboard()->panelBodyRightSecondLine4;
		$response["panelBodyRightSecondLine5"] = (string)$this->GetXmlRootDashboard()->panelBodyRightSecondLine5;
		$response["panelTitleRightThird"] = (string)$this->GetXmlRootDashboard()->panelTitleRightThird;
		$response["panelBodyRightThirdLine1"] = (string)$this->GetXmlRootDashboard()->panelBodyRightThirdLine1;
		$response["panelBodyRightThirdLine2"] = (string)$this->GetXmlRootDashboard()->panelBodyRightThirdLine2;
		$response["panelBodyRightThirdLine3"] = (string)$this->GetXmlRootDashboard()->panelBodyRightThirdLine3;
		$response["panelBodyRightThirdLine4"] = (string)$this->GetXmlRootDashboard()->panelBodyRightThirdLine4;
		$response["addressTitle"] = (string)$this->GetXmlRootDashboard()->addressTitle;
		$response["addressLine1"] = (string)$this->GetXmlRootDashboard()->addressLine1;
		$response["addressLine2"] = (string)$this->GetXmlRootDashboard()->addressLine2;
		$response["codePostal"] = (string)$this->GetXmlRootDashboard()->codePostal;
		$response["city"] = (string)$this->GetXmlRootDashboard()->city;
		$response["country"] = (string)$this->GetXmlRootDashboard()->country;

		foreach($this->GetXmlRootDashboard()->movies->children() as $youtube)
		{
			$response["movies"][] = (string)$youtube;
		}


		return $response;
	}
}

class DashboardFactory
{
    public static function create()
    {
        return new Dashboard();
    }
}

?>