<?php
	class ProductosModel{
		public function listar($id=null){
			$listaProductosColecciones=array(
				"Coleccion_Titulo"=>"Ejemplo",
				"Productos"=>array
				(
				"ProductoA"=>array("Precio"=>500,"img"=>"vestidomuestra.jpg","id"=>1),
				"ProductoB"=>array("Precio"=>400,"img"=>"vestidomuestra.jpg","id"=>2),
				"ProductoC"=>array("Precio"=>300,"img"=>"vestidomuestra.jpg","id"=>3),
				"ProductoD"=>array("Precio"=>200,"img"=>"vestidomuestra.jpg","id"=>4)
				)
			);
			return $listaProductosColecciones;
		}
		
		public function listarHombre(){
			$listaProductosColecciones=array(
				"Coleccion_Titulo"=>"Ejemplo Hombre",
				"Productos"=>array
				(
				"ProductoA"=>array("Precio"=>500,"img"=>"vestidomuestra.jpg","id"=>1),
				"ProductoB"=>array("Precio"=>400,"img"=>"vestidomuestra.jpg","id"=>2),
				"ProductoC"=>array("Precio"=>300,"img"=>"vestidomuestra.jpg","id"=>3),
				"ProductoD"=>array("Precio"=>200,"img"=>"vestidomuestra.jpg","id"=>4)
				)
			);
			return $listaProductosColecciones;
		}
		
		public function listarMujer(){
			$listaProductosColecciones=array(
				"Coleccion_Titulo"=>"Ejemplo Mujer",
				"Productos"=>array
				(
				"ProductoA"=>array("Precio"=>500,"img"=>"vestidomuestra.jpg","id"=>1),
				"ProductoB"=>array("Precio"=>400,"img"=>"vestidomuestra.jpg","id"=>2),
				"ProductoC"=>array("Precio"=>300,"img"=>"vestidomuestra.jpg","id"=>3),
				"ProductoD"=>array("Precio"=>200,"img"=>"vestidomuestra.jpg","id"=>4)
				)
			);
			return $listaProductosColecciones;
		}
		
		public function detalleProducto($id){
			$datos=array(
				"Nombre"=>"Ejemplo",
				"Precio"=>500,
				"Descripcion"=>"Descripcion ejemplo!",
				"Img1"=>"prenda.png",
				"Img2"=>"prenda.png",
				"Img3"=>"prenda.png",
				"ImgGrande"=>"prendagrande.png"
			);
			return $datos;
		}
	}
?>