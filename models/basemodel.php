<?php
	require_once("models/database.php");
	class BaseModel{
		protected $db;
		public function __construct(){
			$this->db=Database::getInstance();
		}
		
		public function clean($data){
			$cleanData=array();
			foreach($data as $key=>$val){
				$cleanData[$key]=$this->db->real_escape_string($val);
			}
			return $cleanData;
		}
		
		public function setSession($position,$values){
			$_SESSION[$position]=$values;
		}
		
		public function loggedIn(){
			if(isset($_SESSION['user']))
				return true;
			return false;
		}
		
		public function login($data){
			$data=$this->clean($data);
			if(!isset($_SESSION['user'])){
				extract($data);
				$res=$this->db->query("SELECT COUNT(*) as Cantidad FROM usuarios WHERE Correo='$email' AND Password='$password'");
				$cant=$res->fetch_assoc();
				$res->free();
				if($cant['Cantidad']>0){
					$this->setSession("user",$email);
					return true;
				}
				return false;
			}
			return false;
			
		}
		
		public function userIsAdmin(){
			if(isset($_SESSION['user'])){
				$email=$_SESSION['user'];
				$res=$this->db->query("SELECT COUNT(*) as Cantidad FROM usuarios WHERE Correo='$email' AND Clase='Admin'");
				$cant=$res->fetch_assoc();
				$res->free();
				if($cant['Cantidad']>0)
					return true;
				return false;
			}
			return false;
			
		}
		
		public function unsetSession($position){
			if(isset($_SESSION[$position]))
				unset($_SESSION[$position]);
		}
	}


?>