<?php
	class HomeModel{
		public function listarColecciones(){
			$listaColecciones=array(
				"Coleccion A"=>
				array(
					"Descripcion"=>"Ejemplo",
					"Img"=>"prenda.png",
					"Id"=>1
				),
				"Coleccion B"=>
				array(
					"Descripcion"=>"Ejemplo",
					"Img"=>"prenda.png",
					"Id"=>2
				),
				"Coleccion C"=>
				array(
					"Descripcion"=>"Ejemplo",
					"Img"=>"prenda.png",
					"Id"=>3
				),
				"Coleccion D"=>
				array(
					"Descripcion"=>"Ejemplo",
					"Img"=>"prenda.png",
					"Id"=>4
				)
			);
			
			return $listaColecciones;
		}
		
		public function guardarUsuario($datos){
			$usuarios=array("dokorof2","dokorof3");
			foreach($usuarios as $usuario){
				if($usuario==$datos['usuario'])//usuario existe fake
					return false;
			}
			//Insertar en la base
			return true;
		}
		
		public function enviarContacto($datos){
			//Enviar mensaje
			return true;
		}
		
		public function guardarSuscripcion($datos){
			$usuarios=array("dokorof2@hotmail.com","dokorof3@hotmail.com");
			foreach($usuarios as $usuario){
				if($usuario==$datos['email'])//usuario existe fake
					return false;
			}
			//Insertar en la base
			return true;
		}
		
		public function cambiarPassword($datos){
			$usuarios=array("dokorof2@hotmail.com","dokorof3@hotmail.com");
			foreach($usuarios as $usuario){
				if($usuario==$datos['email'])//usuario existe fake
					return true;
			}
			//Insertar en la base
			return false;
		}
	}

?>