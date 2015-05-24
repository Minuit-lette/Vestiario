<?php
	require('models/homemodel.php');
	class Home extends BaseController{
		public function __construct(){
			$this->defaultMethod="mostrarIndice";
			$this->model=new HomeModel;
		}
		
		public function mostrarIndice(){
			$datos_modal=array("@@ModalError@@"=>"");
			if($this->validateExists($_POST,array("emailSuscripcion"))){
				if($this->validateArrayTypes($_POST,array("emailSuscripcion"=>"email"))){
					$datos=array(
						"email"=>$_POST['emailSuscripcion']
					);
					$exito=$this->model->guardarSuscripcion($datos);
					if($exito){
						$datos_modal=array(
							"@@ModalError@@"=>$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Te suscribiste de forma exitosa"))
						);
					}
					else{
						$datos_modal=array(
							"@@ModalError@@"=>$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Ya existe una suscripción previa de este correo"))
						);
					}
				}
				else{
					$datos_modal=array(
						"@@ModalError@@"=>$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Correo inválido"))
					);
				}
			}
			else if($this->validateExists($_POST,array("sessionuser","sessionpassword"))){
				if($this->validateArrayTypes($_POST,array("sessionuser"=>"email","sessionpassword"=>"password"))){
					$datos=array(
						"email"=>$_POST['sessionuser'],
						"password"=>$_POST['sessionpassword']
					);
					$exito=$this->model->login($datos);
					if($exito){
						$datos_modal=array(
							"@@ModalError@@"=>$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Iniciaste sesión de forma exitosa"))
						);
						if($this->model->userIsAdmin())
							$this->redirect("admin","home");
					}
					else{
						$datos_modal=array(
							"@@ModalError@@"=>$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Datos de inicio de sesión incorrectos"))
						);
					}
				}
				else{
					$datos_modal=array(
						"@@ModalError@@"=>$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Datos inválidos"))
					);
				}
			}
			$lista=$this->model->listarColecciones();
			$colecciones_string="";
			foreach($lista as $nombre=>$opciones){
				$datos=array(
					"@@ColeccionTitulo@@"=>$nombre,
					"@@ColeccionDescripcion@@"=>$opciones["Descripcion"],
					"@@ColeccionImg@@"=>$opciones["Img"],
					"@@ColeccionId@@"=>$opciones["Id"]
				);
				$colecciones_string.=$this->getFilledTemplate('coleccion_descripcion',$datos);
			}
			$datos=array(
				"@@Header@@"=>$this->getHeader(),
				"@@ListaColecciones@@"=>$colecciones_string,
				"@@Footer@@"=>$this->getFilledTemplate("footer")
			) + $datos_modal;
			echo $this->getFilledTemplate("portada",$datos);
		}
		
		public function registrar(){
			if($this->validateExists($_POST,array("password","email","cpassword","nombre"))){
				if($this->validateArrayTypes($_POST,array("password"=>"password","email"=>"email","cpassword"=>"password","nombre"=>"name")) && $_POST['password']==$_POST['cpassword']){
					$datos=array(
						"nombre"=>$_POST['nombre'],
						"email"=>$_POST['email'],
						"password"=>$_POST['password']
					);
					$exito=$this->model->guardarUsuario($datos);
					if($exito){
						$datos=array(
							"@@Header@@"=>$this->getHeader(),
							"@@Footer@@"=>$this->getFilledTemplate("footer"),
							"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"Usuario creado de forma exitosa"))
						);
						echo $this->getFilledTemplate("registro",$datos);
					}
					else{
						$datos=array(
							"@@Header@@"=>$this->getHeader(),
							"@@Footer@@"=>$this->getFilledTemplate("footer"),
							"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"El correo ya existe"))
						);
						echo $this->getFilledTemplate("registro",$datos);
					}
				}
				else{
					$datos=array(
						"@@Header@@"=>$this->getHeader(),
						"@@Footer@@"=>$this->getFilledTemplate("footer"),
						"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"Tipos inválidos de datos"))
					);
					echo $this->getFilledTemplate("registro",$datos);
				}
			}
			
			else{
				$datos=array(
					"@@Header@@"=>$this->getHeader(),
					"@@Footer@@"=>$this->getFilledTemplate("footer"),
					"@@Errores@@"=>""
				);
				echo $this->getFilledTemplate("registro",$datos);
			
			}
		}
		
		public function contacto(){
			if($this->validateExists($_POST,array("nombre","apellidos","email","mensaje"))){
				if($this->validateArrayTypes($_POST,array("nombre"=>"name","email"=>"email","apellidos"=>"name","mensaje"=>"text"))){
					$datos=array(
						"nombre"=>$_POST['nombre'],
						"email"=>$_POST['email'],
						"apellidos"=>$_POST['apellidos'],
						"mensaje"=>$_POST['mensaje']
					);
					$exito=$this->model->enviarContacto($datos);
					if($exito){
						$datos=array(
							"@@Header@@"=>$this->getHeader(),
							"@@Footer@@"=>$this->getFilledTemplate("footer"),
							"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"Mensaje enviado de forma exitosa"))
						);
						echo $this->getFilledTemplate("contacto",$datos);
					}
					else{
						$datos=array(
							"@@Header@@"=>$this->getHeader(),
							"@@Footer@@"=>$this->getFilledTemplate("footer"),
							"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"El mensaje no pudo ser enviado, intente nuevamente después"))
						);
						echo $this->getFilledTemplate("contacto",$datos);
					}
				}
				else{
					$datos=array(
						"@@Header@@"=>$this->getHeader(),
						"@@Footer@@"=>$this->getFilledTemplate("footer"),
						"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"Tipos inválidos de datos"))
					);
					echo $this->getFilledTemplate("contacto",$datos);
				}
			}
			
			else{
				$datos=array(
					"@@Header@@"=>$this->getHeader(),
					"@@Footer@@"=>$this->getFilledTemplate("footer"),
					"@@Errores@@"=>""
				);
				echo $this->getFilledTemplate("contacto",$datos);
			
			}
		}
		
		public function acercade(){
			$datos=array(
				"@@Header@@"=>$this->getHeader(),
				"@@Footer@@"=>$this->getFilledTemplate("footer")
			);
			echo $this->getFilledTemplate("acercaDe",$datos);
		}
		
		public function recuperar(){
			if($this->validateExists($_POST,array("password","cpassword","email"))){
				if($this->validateArrayTypes($_POST,array("password"=>"password","email"=>"email","cpassword"=>"password"))){
					$datos=array(
						"email"=>$_POST['email'],
						"password"=>$_POST['password']
					);
					$exito=$this->model->cambiarPassword($datos);
					if($exito){
						$datos=array(
							"@@Header@@"=>$this->getHeader(),
							"@@Footer@@"=>$this->getFilledTemplate("footer"),
							"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"Mensaje enviado de forma exitosa"))
						);
						echo $this->getFilledTemplate("recuperarContra",$datos);
					}
					else{
						$datos=array(
							"@@Header@@"=>$this->getHeader(),
							"@@Footer@@"=>$this->getFilledTemplate("footer"),
							"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"El mensaje no pudo ser enviado, verifica que el correo sea correcto y exista"))
						);
						echo $this->getFilledTemplate("recuperarContra",$datos);
					}
				}
				else{
					$datos=array(
						"@@Header@@"=>$this->getHeader(),
						"@@Footer@@"=>$this->getFilledTemplate("footer"),
						"@@Errores@@"=>$this->getFilledTemplate("errores",array("@@Error@@"=>"Tipos inválidos de datos"))
					);
					echo $this->getFilledTemplate("recuperarContra",$datos);
				}
			}
			else{
				$datos=array(
					"@@Header@@"=>$this->getHeader(),
					"@@Footer@@"=>$this->getFilledTemplate("footer"),
					"@@Errores@@"=>""
				);
				echo $this->getFilledTemplate("recuperarContra",$datos);
			}
		}
		
		public function logout(){
			$this->model->unsetSession('user');
			$this->redirect("home","mostrarIndice");
		}
	}
?>