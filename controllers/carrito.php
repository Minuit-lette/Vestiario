<?php
	require_once('models/carritomodel.php');
	class Carrito extends BaseController{
		public function __construct(){
			$this->model= new CarritoModel;
			$this->defaultMethod="mostrar";
		}
		
		public function mostrar(){
			$carrito=$this->model->getCarrito();
			$productos_string="";
			foreach($carrito['Productos'] as $id=>$producto){
				$datos=array(
					"@@IdProducto@@"=>$id,
					"@@ImgProducto@@"=>$producto['Img'],
					"@@IdColeccion@@"=>$producto['IdColeccion'],	 
					"@@NombreProducto@@"=>$producto['Nombre'],
					"@@NombreColeccion@@"=>$producto['Coleccion'],
					"@@Status@@"=>$producto['Status'],
					"@@ProductoDisponibilidad@@"=>$producto['Disponibilidad'],
					"@@Cantidad@@"=>$producto['Cantidad'],
					"@@PrecioUnitario@@"=>$producto['PrecioUnitario'],
					"@@Importe@@"=>$producto['Importe']
				);
				$productos_string.=$this->getFilledTemplate("carrito_producto",$datos);
			}
			$datos=array(
				"@@Header@@"=>$this->getFilledTemplate("header"),
				"@@Footer@@"=>$this->getFilledTemplate("footer"),
				"@@ListaProductos@@"=>$productos_string,
				"@@Subtotal@@"=>$carrito['Subtotal'],
				"@@Envio@@"=>$carrito['Envio'],
				"@@Total@@"=>$carrito['Total']
			);
			echo $this->getFilledTemplate("carrito",$datos);
		}
	}

?>