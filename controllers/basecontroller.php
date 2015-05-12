<?php
	class BaseController{
		protected $defaultMethod;
		protected $model;
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
					return ctype_digit($value);
				
				case 'email':
					return filter_var($value,FILTER_VALIDATE_EMAIL);
					
				case 'password':
					return true;
					
				case 'user':
					return true;
					
				case 'name':
					return ctype_alpha(str_replace(' ','',$value));
					
				case 'text':
					return true;
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
	}


?>