<?php
	class HomeModel extends BaseModel{
		public function listarColecciones(){
			$result=$this->db->query("SELECT * FROM colecciones");
			$listado=$result->fetch_all(MYSQLI_ASSOC);
			$listaColecciones=array();
			foreach($listado as $res){
				$listaColecciones[$res['Nombre']]=array(
					"Img"=>$res['Imagen'],
					"Descripcion"=>utf8_encode($res['Descripcion']),
					"Id"=>$res['IdColecciones']
				);
			}
			return $listaColecciones;
		}
		
		public function guardarUsuario($datos){
			$datos=$this->clean($datos);
			extract($datos);
			$res=$this->db->query("SELECT COUNT(*) as Cantidad FROM usuarios WHERE Correo='$email'");
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
			$mail=new PHPMailer;
			$mail->isSMTP();
			$mail->Host=MAIL_SERVER;
			$mail->SMTPAuth=true;
			$mail->Username=MAIL_USER;
			$mail->Password=MAIL_PASSWORD;
			$mail->SMTPSecure=MAIL_SECURITY;
			$mail->Port=MAIL_PORT;
			$mail->From ='vestiario@dokorof.com';
			$mail->FromName = 'Vestiario';
			$mail->addAddress($datos['email'],$datos['nombre'].' '.$datos['apellidos']);
			$mail->addAddress('vestiario@dokorof.com','Vestiario');
			$mail->isHTML(true);
			$mail->Subject='Consulta al Vestiario';
			$mail->Body=$datos['nombre'].' '.$datos['apellidos'].' comenta:<br/>'.$datos['mensaje'];
			echo $mail->ErrorInfo;
			return $mail->send();
		}
		
		public function guardarSuscripcion($datos){
			$datos=$this->clean($datos);
			extract($datos);
			$res=$this->db->query("SELECT COUNT(*) as Cantidad FROM suscripciones WHERE Correo='$email'");
			$cant=$res->fetch_assoc();
			$res->free();
			if($cant['Cantidad']==0){
				$this->db->query("
								INSERT INTO suscripciones(Correo) VALUES('$email')
								");
				if($this->db->affected_rows>0)
					return true;
				return false;
			}
			return false;
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