<?php
	class BaseController{
		protected $defaultMethod;
		protected $model;
		public function redirect($ctl,$method,$extra=""){
			header("Location: ?ctl=".$ctl."&act=".$method.$extra);
			die();
		}
		public function run(){
			$metodo=$this->defaultMethod;
			if(!(isset($_GET['act']) && method_exists(get_class($this),$_GET['act'])))
				$this->$metodo();
			else if(isset($_GET['act']) && method_exists(get_class($this),$_GET['act']))
				$this->$_GET['act']();
		}
		protected function getFilledTemplate($file,$arr=array()){
			$file_string=file_get_contents('views/'.$file.'.html');
			foreach($arr as $key=>$value){
				$file_string=str_replace($key,$value,$file_string);
			}
			return $file_string;
		}
		
		protected function validate($value,$type){
			switch($type){
				case 'int':
					return filter_var($value,FILTER_VALIDATE_INT);
				case 'positiveInt':
					return filter_var($value,FILTER_VALIDATE_INT,array('min_range'=>0));
				case 'email':
					return filter_var($value,FILTER_VALIDATE_EMAIL);
					
				case 'password':
					return true;
					
				case 'name':
					return ctype_alpha(str_replace(' ','',$value));
					
				case 'text':
					return true;
					
				case 'usertype':
					return ($value=='Usuario' || $value=='Admin');
				
				case 'category':
					return ($value=='H' || $value=='M');
				
				case 'optionalPassword':
					return ($value=='' || $this->validate($value,'password'));
					
				case 'optionalName':
					return ($value=='' || $this->validate($value,'name'));
			}
			return false;
		}
		
		protected function validateExists($var,$values){
			foreach($values as $val){
				if(!isset($var[$val]))
					return false;
			}
			return true;
		}
		
		protected function validateArrayTypes($arr,$types){
			foreach($arr as $key=>$val){
				if(isset($types[$key])){
					$success=$this->validate($val,$types[$key]);
					if(!$success)
						return false;
				}
				else
					return false;
			}
			return true;
		}
		public function show404(){
			echo $this->getFilledTemplate('404');
		}
		
		public function getHeader(){
			if($this->model->loggedIn()){
				return $this->getFilledTemplate("header",array("@@Usuario@@"=>$this->getFilledTemplate("sesion-abierta")));
			}
			else
				return $this->getFilledTemplate("header",array("@@Usuario@@"=>$this->getFilledTemplate("sesion-cerrada")));
		}
	}


?>