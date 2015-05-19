<?php
	class CarritoModel extends BaseModel{
		public function getCarrito(){
			$carrito=array(
				"Productos"=>array(
					1=>array(
						"Nombre"=>"Producto 1",
						"Coleccion"=>"Coleccion 1",
						"IdColeccion"=>1,
						"Img"=>"prenda.png",
						"Status"=>"success",
						"Disponibilidad"=>"Disponible",
						"Cantidad"=>3,
						"PrecioUnitario"=>300,
						"Importe"=>900
					),
					2=>array(
						"Nombre"=>"Producto 2",
						"Coleccion"=>"Coleccion 1",
						"IdColeccion"=>1,
						"Img"=>"prenda.png",
						"Status"=>"danger",
						"Disponibilidad"=>"No Disponible",
						"Cantidad"=>3,
						"PrecioUnitario"=>300,
						"Importe"=>900
					),
					3=>array(
						"Nombre"=>"Producto 3",
						"Coleccion"=>"Coleccion 2",
						"IdColeccion"=>2,
						"Img"=>"prenda.png",
						"Status"=>"success",
						"Disponibilidad"=>"Disponible",
						"Cantidad"=>3,
						"PrecioUnitario"=>300,
						"Importe"=>900
					)
				),
				"Subtotal"=>2700,
				"Envio"=>300,
				"Total"=>3000
			);
			return $carrito;
		}
	}

?>