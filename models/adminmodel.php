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
			else
				$this->db->query("UPDATE usuarios SET Nombre='$nombre',Clase='$tipo',Password='$password' WHERE Correo='$email'");
			return ($this->db->affected_rows>0);
		}
		
	}

?>