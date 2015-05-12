<?php
	class ColeccionesModel{
		public function listar(){
			$listaColecciones=array(
				"Coleccion_Titulo"=>"Ejemplo",
				"Productos"=>array
				(
				"ProductoA"=>array("Precio"=>500,"img"=>"vestidomuestra.jpg"),
				"ProductoB"=>array("Precio"=>400,"img"=>"vestidomuestra.jpg"),
				"ProductoC"=>array("Precio"=>300,"img"=>"vestidomuestra.jpg"),
				"ProductoD"=>array("Precio"=>200,"img"=>"vestidomuestra.jpg")
				)
			);
			return $listaColecciones;
		}
	}
?>