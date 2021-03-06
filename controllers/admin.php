<?php
	require_once('models/adminmodel.php');
	class Admin extends BaseController{
		public function __construct(){
			$this->model= new AdminModel;
			$this->defaultMethod="home";
		}
		public function home(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-home",$datos);
			
		}
		public function productos(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-listar-productos",$datos);
		}
		
		public function agregarProducto(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-alta-productos",$datos);
		}
		
		public function usuarios(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$mensaje="";
			$resultado="";
			if($this->validateExists($_POST,array("busqueda"))){
				if($this->validateArrayTypes($_POST,array("busqueda"=>"email"))){
					$mensaje=$this->getFilledTemplate("mensaje-busqueda",array(
						"@@NombreUsuario@@"=>$_POST['busqueda']));
					$resultadoBusqueda=$this->model->buscarUsuario($_POST['busqueda']);
					if(count($resultadoBusqueda)>0){
						$datosBusqueda=array(
							"@@CorreoUsuario@@"=>$resultadoBusqueda['Correo'],
							"@@NombreUsuario@@"=>$resultadoBusqueda['Nombre'],
							"@@TipoUsuario@@"=>($resultadoBusqueda['Clase']=='Usuario')?'selected':'',
							"@@TipoAdmin@@"=>($resultadoBusqueda['Clase']=='Admin')?'selected':''
						);
						$resultado=$this->getFilledTemplate("resultado-busqueda",$datosBusqueda);
					}
				}
			}
			if($this->validateExists($_POST,array("nombre","email","password","tipo"))){
				if($this->validateArrayTypes($_POST,array("nombre"=>"name","email"=>"email","password"=>"optionalPassword","tipo"=>"usertype"))){
					$resultadoBusqueda=$this->model->buscarUsuario($_POST['email']);
					if(count($resultadoBusqueda)>0){
						$exito=$this->model->modificarUsuario($_POST);
						if($exito)
							$mensaje="Usuario ".$_POST['email']." modificado exitosamente";
						else
							$mensaje="Error al intentar modificar al usuario ".$_POST['email'].' los datos son los mismos que antes';
					}
					else
						$mensaje="Datos inválidos, no existe el usuario ".$_POST['email'];
				}
				else
					$mensaje="Datos inválidos ingresados";
				
			}
			$datos=array(
					"@@AdminHeader@@"=>$this->getFilledTemplate('admin-header'),
					"@@MensajeBusqueda@@"=>$mensaje,
					"@@ResultadoBusqueda@@"=>$resultado
				);
			echo $this->getFilledTemplate("admin-lista-usuarios",$datos);
		}
		
		public function editarProducto(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-edita-productos",$datos);
		}
		
		public function colecciones(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$errores="";
			$errores_modificacion="";
			$errores_eliminacion="";
			if(isset($_GET['error'])){
				switch($_GET['error']){
					case 0:
						$errores="Colección subida exitosamente";
					break;
					
					case 1:
						$errores="Archivo inválido";
					break;
					case 2:
						$errores="Datos inválidos";
					break;
				}
			}
			if(isset($_GET['remover']) && $this->validate($_GET['remover'],"positiveInt")){
				
				if(!$this->model->eliminarColeccion($_GET['remover']))
					$errores_modificacion="No se pudo eliminar la colección";
				else
					$errores_modificacion="Colección eliminada correctamente";
			}
			$colecciones=$this->model->colecciones();
			$colecciones_string="";
			foreach($colecciones as $coleccion){
				$datos=array(
					"@@IdColeccion@@"=>$coleccion['IdColecciones'],
					"@@NombreColeccion@@"=>utf8_encode($coleccion['Nombre']),
					"@@Hombre@@"=>($coleccion['Categoria']=='H')?"selected":"",
					"@@Mujer@@"=>($coleccion['Categoria']=='M')?"selected":""
					
				);
				$colecciones_string.=$this->getFilledTemplate('coleccion-fila',$datos);
			}
			$datos=array(
				"@@AdminHeader@@"=>$this->getFilledTemplate('admin-header'),
				"@@ErroresAlta@@"=>$errores,
				"@@ErroresModificacion@@"=>$errores_modificacion,
				"@@ErroresEliminacion@@"=>$errores_eliminacion,
				"@@ListaColecciones@@"=>$colecciones_string
			);
			echo $this->getFilledTemplate("admin-administra-colecciones",$datos);
		}
		
		public function pedidos(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-administra-pedidos",$datos);
		}
		
		public function crearColeccion(){
			if($this->validateExists($_POST,array("Nombre","Categoria","Descripcion"))){
				if($this->validateArrayTypes($_POST,array("Nombre"=>"text","Categoria"=>"category","Descripcion"=>"text"))){
					if(is_uploaded_file($_FILES['Imagen']['tmp_name']) && in_array(strtolower(end((explode(".",$_FILES['Imagen']['name'])))),array("gif","jpeg","jpg","png"))){
						if(move_uploaded_file($_FILES['Imagen']['tmp_name'],'./imagenes/'.basename($_FILES['Imagen']['name']))){
							$datos=$_POST+array("Imagen"=>basename($_FILES['Imagen']['name']));
							$this->model->crearColeccion($datos);
							$this->redirect("admin","colecciones","&error=0");
						}
						else
							$this->redirect("admin","colecciones","&error=1");
					}
					else
						$this->redirect("admin","colecciones","&error=1");
				}
				else
					$this->redirect("admin","colecciones","&error=2");
					
			}
			else
				$this->redirect("admin","colecciones","&error=2");
		}
	}


?>