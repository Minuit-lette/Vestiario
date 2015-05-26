<?php
	class AdminModel extends BaseModel{
		public function buscarUsuario($correo){
			$correo=$this->cleanSingle($correo);
			$consulta=$this->db->query("SELECT * FROM usuarios WHERE Correo='$correo'");
			if(is_object($consulta))
				return $consulta->fetch_assoc();
			return array();
		}
		public function modificarUsuario($datos){
			$datos=$this->clean($datos);
			extract($datos);
		
			if($password=='')
				$this->db->query("UPDATE usuarios SET Nombre='$nombre',Clase='$tipo' WHERE Correo='$email'");
			else{
				$password=md5(sha1($password));
				$this->db->query("UPDATE usuarios SET Nombre='$nombre',Clase='$tipo',Password='$password' WHERE Correo='$email'");
			}
			return ($this->db->affected_rows>0);
		}
		
		public function crearColeccion($datos){
			$datos=$this->clean($datos);
			extract($datos);
			$this->db->query("INSERT INTO colecciones(Nombre,Categoria,Imagen,Descripcion) VALUES('$Nombre','$Categoria','$Imagen','$Descripcion')");
		}
		
		public function colecciones(){
			$result=$this->db->query("SELECT * FROM colecciones");
			if(is_object($result) && $result->num_rows>0)
				return $result->fetch_all(MYSQLI_ASSOC);
			return array();
		}
		
		public function eliminarColeccion($id){
			$this->db->query("DELETE FROM colecciones WHERE IdColecciones=$id");
			return ($this->db->affected_rows>0);
		}
	}

?>