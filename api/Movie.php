<?php

require_once("XmlDataAccess.php");

class Movie extends XmlDataAccess {

	public function __construct()
    {
    	parent::__construct();
    }

	public function GetMovies($id)
	{
		$response = array();

		if(is_null($this->GetXmlRootMovie())){
			$response["status"] = "error";
	        $response["message"] = "Technical error - Movie's data are not accessible!";
	        return $response;
		}

		if (isset($this->GetXmlRootMovie()->movies['id']) && $this->GetXmlRootMovie()->movies['id'] == $id)
		{
			foreach($this->GetXmlRootMovie()->movies->children() as $youtube)
			{
				$response[] = (string)$youtube;
			}
		}
		else 
		{
            $response['status'] = "error";
            $response['message'] = 'No such movies have been stored';
        }

		return $response;
	}
}

class MovieFactory
{
    public static function create()
    {
        return new Movie();
    }
}

?>