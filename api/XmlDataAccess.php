<?php
	require_once("Enum.php"); 

	// Give an access to the dedicated XML file
	class XmlDataAccess {

		private $xmlFileConfig;
		private $xmlRootConfig;		

		private $xmlFileStructure;
		private $xmlRootStructure;

		private $xmlFileDashboard;
		private $xmlRootDashboard;

		private $xmlFileExposant;
		private $xmlRootExposant;

		private $xmlFileService;
		private $xmlRootservice;

		private $xmlFileMovie;
		private $xmlRootMovie;

		private $xmlFileContact;
		private $xmlRootContact;

		private $xmlFileUsers;
		private $xmlRootUsers;

		public function __construct() {

			$this->xmlFileConfig = DataFileEnum::Config;
			$this->xmlFileStructure = DataFileEnum::Structure;
			$this->xmlFileDashboard = DataFileEnum::Dashboard;
			$this->xmlFileExposant = DataFileEnum::Exposant;
			$this->xmlFileService = DataFileEnum::Service;
			$this->xmlFileContact = DataFileEnum::Contact;
			$this->xmlFileMovie = DataFileEnum::Movie;
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

		public function GetXmlFileDashboard(){
			return $this->xmlFileDashboard;
		}
		
		public function GetXmlRootDashboard(){
			// Dashboard file Creation if doesn't exist
			if(file_exists($this->xmlFileDashboard))
				$this->xmlRootDashboard = simplexml_load_file($this->xmlFileDashboard);	
			else 
			{
				$content = "<olipp></olipp>";
				$this->xmlRootDashboard = $this->CreateFile($this->xmlFileDashboard, $content);
			}

			return $this->xmlRootDashboard;
		}

		public function GetXmlFileExposant(){
			return $this->xmlFileExposant;
		}

		public function GetXmlRootExposant(){
			// Exposant file Creation if doesn't exist
			if(file_exists($this->xmlFileExposant))
				$this->xmlRootExposant = simplexml_load_file($this->xmlFileExposant);	
			else 
			{
				$content = "<olipp></olipp>";
				$this->xmlRootExposant = $this->CreateFile($this->xmlFileExposant, $content);
			}

			return $this->xmlRootExposant;
		}

		public function GetXmlFileService(){
			return $this->xmlFileService;
		}

		public function GetXmlRootService(){
			// Service file Creation if doesn't exist
			if(file_exists($this->xmlFileService))
				$this->xmlRootService = simplexml_load_file($this->xmlFileService);	
			else 
			{
				$content = "<olipp></olipp>";
				$this->xmlRootService = $this->CreateFile($this->xmlFileService, $content);
			}

			return $this->xmlRootService;
		}

		public function GetXmlFileMovie(){
			return $this->xmlFileMovie;
		}

		public function GetXmlRootMovie(){
			// Movie file Creation if doesn't exist
			if(file_exists($this->xmlFileMovie))
				$this->xmlRootMovie = simplexml_load_file($this->xmlFileMovie);	
			else 
			{
				$content = "<olipp></olipp>";
				$this->xmlRootMovie = $this->CreateFile($this->xmlFileMovie, $content);
			}

			return $this->xmlRootMovie;
		}

		public function GetXmlFileContact(){
			return $this->xmlFileContact;
		}

		public function GetXmlRootContact(){
			// Contact file Creation if doesn't exist
			if(file_exists($this->xmlFileContact))
				$this->xmlRootContact = simplexml_load_file($this->xmlFileContact);	
			else 
			{
				$content = "<olipp></olipp>";
				$this->xmlRootContact = $this->CreateFile($this->xmlFileContact, $content);
			}

			return $this->xmlRootContact;
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