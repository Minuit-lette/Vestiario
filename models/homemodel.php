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
			$password=md5(sha1($password));
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
			//echo $mail->ErrorInfo;
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
			$datos=$this->clean($datos);
			extract($datos);
			$token=md5(sha1(uniqid()));
			$password=md5(sha1($password));
			$tiempo=time()+(60*60*24*7);
			$this->db->query("DELETE FROM recuperacion WHERE Correo='$email'");
			$this->db->query("INSERT INTO recuperacion(Correo,Password,Token) VALUES('$email','$password','$token')");
			$url="http://localhost/proyectoweb/?ctl=home&act=recuperarToken&correo=$email&token=$token";
			$mensaje="
				Para recuperar tu contraseña, da <a href='$url'>Click aquí</a>
			";
			$mensaje=utf8_decode($mensaje);
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
			$mail->addAddress($email);
			$mail->isHTML(true);
			$mail->Subject=utf8_decode('Recuperar la contraseña');
			$mail->Body=$mensaje;
			//echo $mail->ErrorInfo;
			return $mail->send();
		}
		
		public function confirmaCambioPassword($datos){
			$datos=$this->clean($datos);
			extract($datos);
			$result=$this->db->query("SELECT * FROM recuperacion WHERE Correo='$correo' AND Token='$token' AND NOW()<(Tiempo + INTERVAL 1 DAY)");
			if(is_object($result) && $result->num_rows>0){
				$row=$result->fetch_assoc();
				$password=$row['Password'];
				$this->db->query("UPDATE usuarios SET Password='$password' WHERE Correo='$correo'");
				return true;
			}
			return false;
		}
		
		
	}

?>