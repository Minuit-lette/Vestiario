<?php
	require_once('models/carritomodel.php');
	class Carrito extends BaseController{
		public function __construct(){
			$this->model= new CarritoModel;
			$this->defaultMethod="mostrar";
		}
		
		public function mostrar(){
			$datos_m=array(
					"@@Modal@@"=>""
				);
			if(isset($_GET['id']) && $this->validate($_GET['id'],'positiveInt') && $this->validateExists($_POST,array("talla","cantidad"))){
				if($this->validateArrayTypes($_POST,array("talla"=>"int","cantidad"=>"positiveInt"))){
					$producto=$_GET+$_POST;
					if(!$this->model->setCarrito($producto)){
						$datos_m=array(
							"@@Modal@@"=>$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Producto inválido"))
						);
					}
				}
				else{
					$datos_m=array(
						"@@Modal@@"=>$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Producto inválido"))
					);
				}
			}
			$carrito=$this->model->getCarrito();
			$productos_string="";
			if(!$this->model->loggedIn())
				$datos_m['@@Modal@@'].=$this->getFilledTemplate("modal-carrito");
			else if(count($carrito['Productos'])!=0)
				$datos_m['@@Modal@@'].=$this->getFilledTemplate("boton-carrito");
			foreach($carrito['Productos'] as $identificador=>$producto){
				$datos=array(
					"@@IdProducto@@"=>$producto['Id'],
					"@@ImgProducto@@"=>$producto['Img'],
					"@@IdColeccion@@"=>$producto['IdColeccion'],	 
					"@@NombreProducto@@"=>$producto['Nombre'],
					"@@NombreColeccion@@"=>$producto['Coleccion'],
					"@@Talla@@"=>$producto['Talla'],
					"@@IdProductoEliminar@@"=>$identificador,
					"@@Cantidad@@"=>$producto['Cantidad'],
					"@@PrecioUnitario@@"=>$producto['PrecioUnitario'],
					"@@Importe@@"=>$producto['Importe']
				);
				$productos_string.=$this->getFilledTemplate("carrito_producto",$datos);
			}
			$datos=array(
				"@@Header@@"=>$this->getHeader(),
				"@@Footer@@"=>$this->getFilledTemplate("footer"),
				"@@ListaProductos@@"=>$productos_string,
				"@@Total@@"=>$carrito['Total']
			)+$datos_m;
			echo $this->getFilledTemplate("carrito",$datos);
		}
		
		public function envio(){
			$modal="";
			if(isset($_GET['error']) && $this->validate($_GET['error'],"text")){
				$modal=$this->getFilledTemplate("modalerror",array("@@Error@@"=>"Datos inválidos"));
			}
				
			$carrito=$this->model->getCarrito();
			if(count($carrito['Productos'])==0 || !$this->model->loggedIn())
				$this->redirect("carrito","mostrar");
			$datos=array(
				"@@Header@@"=>$this->getHeader(),
				"@@Footer@@"=>$this->getFilledTemplate("footer"),
				"@@Modal@@"=>$modal
			);
			echo $this->getFilledTemplate("envio",$datos);
			
		}
		
		public function pago(){
			$carrito=$this->model->getCarrito();
			if(count($carrito['Productos'])==0 || !$this->model->loggedIn())
				$this->redirect("carrito","mostrar");
			if($this->validateExists($_POST,array("Nombre","Apellidos","Correo","Telefono","Pais","Estado","Ciudad","Calle","CodigoPostal"))){
				$datosValidar=array(
					"Nombre"=>"name",
					"Apellidos"=>"name",
					"Correo"=>"email",
					"Telefono"=>"text",
					"Pais"=>"text",
					"Estado"=>"text",
					"Ciudad"=>"text",
					"Calle"=>"text",
					"CodigoPostal"=>"text"
				);
				if($this->validateArrayTypes($_POST,$datosValidar))
					$this->model->guardarPedido($_POST);
				else $this->redirect("carrito","envio","&error=1");
			}
			else $this->redirect("carrito","envio");
			$carrito=$this->model->getCarrito();
			$productos_string="";
			$productos_string_si="";
			foreach($carrito['Productos'] as $producto){
				$datos=array(
					"@@IdProducto@@"=>$producto['Id'],
					"@@ImgProducto@@"=>$producto['Img'], 
					"@@NombreProducto@@"=>$producto['Nombre'],
					"@@NombreColeccion@@"=>$producto['Coleccion'],
					"@@Talla@@"=>$producto['Talla'],
					"@@Cantidad@@"=>$producto['Cantidad'],
					"@@PrecioUnitario@@"=>$producto['PrecioUnitario'],
					"@@Importe@@"=>$producto['Importe']
				);
				$productos_string.=$this->getFilledTemplate("pago_producto",$datos);
				$productos_string_si.=$this->getFilledTemplate("pago_producto_si",$datos);
			}
			$datos=array(
				"@@Header@@"=>$this->getHeader(),
				"@@Footer@@"=>$this->getFilledTemplate("footer"),
				"@@EnvioCorreo@@"=>$_POST['Correo'],
				"@@ListaProductos@@"=>$productos_string,
				"@@Total@@"=>$carrito['Total']
			);
			$datos_mail=$datos;
			$datos_mail['@@Header@@']="";
			$datos_mail['@@Footer@@']="";
			$datos_mail['@@ListaProductos@@']=$productos_string_si;
			$plantilla=$this->getFilledTemplate("pago_si",$datos_mail);
			$this->model->enviaPedido($plantilla,$_POST);
			echo $this->getFilledTemplate("pago",$datos);
			$this->model->vaciaCarrito();
		}
		
		public function quitar(){
			if(isset($_GET['id']) && $this->validate($_GET['id'],'text')){
				$this->model->unsetCarrito($_GET['id']);
			}
			$this->redirect("carrito","mostrar");
		}
	}

?>