<?php

require_once("XmlDataAccess.php");

class Navigation extends XmlDataAccess {

	public function __construct()
    {
    	parent::__construct();
    }

	public function GetNavigation()
	{
		$response = array();

		if(is_null($this->GetXmlRootStructure())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - Structure's data are not accessible!";
	        return $response;
		}

		$this->ParseRecurseNav($this->GetXmlRootStructure()->navigation, null, $response);

		return $response;
	}

	private function ParseRecurseNav($nav, $parentId, &$tree)
	{
		foreach($nav->children() as $menuItem)
		{
		    $node = array('id' => (string)$menuItem['id'],
		    			  'caption' => (string)$menuItem['caption'],
		    			  'type' => (string)$menuItem['type'],
		    			  'order' => (string)$menuItem['order'],
		    			  'parentId' => (string)$parentId,
		    			  'children' => null);

		    if($menuItem->menuItem != null)
		    { 
		    	$this->ParseRecurseNav($menuItem, $menuItem['id'], $node['children']);	    		    	
		    } 

		    $tree[] = $node;
		}	
	}
}

class NavigationFactory
{
    public static function create()
    {
        return new Navigation();
    }
}

?>