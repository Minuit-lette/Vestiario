<?php
	class HomeModel extends BaseModel{
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
			$datos=$this->clean($datos);
			extract($datos);
			$res=$this->db->query("SELECT COUNT(*) as Cantidad FROM usuarios WHERE Correo='$email' AND Clase='Usuario'");
			$cant=$res->fetch_assoc();
			$res->free();
			if($cant['Cantidad']==0){
				$this->db->query("
								INSERT INTO usuarios(Nombre,Correo,Password,Clase) VALUES('$nombre','$email','$password','Usuario')
								");
				if($this->db->affected_rows>0)
					return true;
				return false;
			}
			return false;
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