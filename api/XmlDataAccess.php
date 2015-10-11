<?php
	require_once("Enum.php"); 

	// Give an access to the dedicated XML file
	class XmlDataAccess {

		private $xmlFileConfig;
		private $xmlRootConfig;

		private $xmlFileStructure;
		private $xmlRootStructure;

		private $xmlFileUsers;
		private $xmlRootUsers;

		public function __construct() {

			$this->xmlFileConfig = DataFileEnum::Config;
			$this->xmlFileStructure = DataFileEnum::Structure;
			$this->xmlFileUsers = DataFileEnum::Users;
		}

		public function GetXmlFileConfig(){
			return $this->xmlFileConfig;
		}

		public function GetXmlRootConfig(){
			// Config file Creation if doesn't exist
			if(file_exists($this->xmlFileConfig))
				$this->xmlRootConfig = simplexml_load_file($this->xmlFileConfig);	
			else 
			{
				$content = "<olipp><version></version><mailer><smtp_server></smtp_server><port></port><smtp_username></smtp_username><smtp_password></smtp_password></mailer></olipp>";
				$this->xmlRootConfig = $this->CreateFile($this->xmlFileConfig, $content);
			}

			return $this->xmlRootConfig;
		}

		public function GetXmlFileStructure(){
			return $this->xmlFileStructure;
		}
		
		public function GetXmlRootStructure(){
			// Structure file Creation if doesn't exist
			if(file_exists($this->xmlFileStructure))
				$this->xmlRootStructure = simplexml_load_file($this->xmlFileStructure);	
			else 
			{
				$content = "<olipp><navigation><menuItem id=\"1\" caption=\"Home\" type=\"dashboard\"/></navigation></olipp>";
				$this->xmlRootStructure = $this->CreateFile($this->xmlFileStructure, $content);
			}

			return $this->xmlRootStructure;
		}

		public function GetXmlFileUsers(){
			return $this->xmlFileUsers;
		}
		
		public function GetXmlRootUsers(){
			// Users file Creation if doesn't exist
			if(file_exists($this->xmlFileUsers))
				$this->xmlRootUsers = simplexml_load_file($this->xmlFileUsers);	
			else 
			{
				$content = "<olipp><users></users></olipp>";
				$this->xmlRootUsers = $this->CreateFile($this->xmlFileUsers, $content);
			}

			return $this->xmlRootUsers;
		}

		private function CreateFile($pathFileName, $content){

			$xmlRoot = null;

			if($newfile = fopen($pathFileName, "w"))
			{
				fwrite($newfile, $content);
				fclose($newfile);

				if(file_exists($this->xmlFileConfig))
					$xmlRoot = simplexml_load_file($pathFileName);
			}

			return $xmlRoot;
		}
	}
?>