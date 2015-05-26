<?php
	class CarritoModel extends BaseModel{
		public function getCarrito(){
			return (isset($_SESSION['carrito']))?$_SESSION['carrito']:array();
		}
		
		public function setCarrito($datos){
			$datos=$this->clean($datos);
			extract($datos);
			$result=$this->db->query("SELECT *,producto.Nombre as ProdNombre,tallas.Nombre as TallaNombre FROM producto INNER JOIN vinculaciontallas ON producto.IdProducto = vinculaciontallas.IdProducto INNER JOIN tallas ON tallas.IdTallas=vinculaciontallas.IdTalla INNER JOIN colecciones ON producto.Coleccion= colecciones.IdColecciones WHERE IdTalla=$talla AND producto.IdProducto=$id");
			if(is_object($result) && $result->num_rows>0){
				$row=$result->fetch_assoc();
				$prod=array(
					$row['IdProducto'].'-'.$row['TallaNombre']=>array(
						"Id"=>$row['IdProducto'],
						"Nombre"=>utf8_encode($row['ProdNombre']),
						"Coleccion"=>utf8_encode($row['Nombre']),
						"IdColeccion"=>$row['Coleccion'],
						"Img"=>$row['Imagen1'],
						"Talla"=>$row['TallaNombre'],
						"Cantidad"=>$cantidad,
						"PrecioUnitario"=>$row['Precio'],
						"Descuento"=>$row['Descuento'],
						"Importe"=>($cantidad*$row['Precio'])-($row['Descuento']*$cantidad)
					)
				);
				if(isset($_SESSION['carrito'])){
					$_SESSION['carrito']['Productos']=$prod+$_SESSION['carrito']['Productos'];
					$total=0;
					foreach($_SESSION['carrito']['Productos'] as $producto){
						$total+=$producto['Importe'];
					}
					$_SESSION['carrito']['Total']=$total;
				}
				else{
					$total=$prod[$row['IdProducto'].'-'.$row['TallaNombre']]['Importe'];
					$_SESSION['carrito']=array(
						"Productos"=>$prod,
						"Total"=>$total
					);
				}
				return true;
			}
			return false;
		}
		
		
		public function vaciaCarrito(){
			if(isset($_SESSION['carrito']['Productos']))
				$_SESSION['carrito']['Productos']=array();
			if(isset($_SESSION['carrito']['Total']))
				$_SESSION['carrito']['Total']=0;
		}
		
		public function unsetCarrito($id){
			if(isset($_SESSION['carrito']['Productos'][$id])){
				unset($_SESSION['carrito']['Productos'][$id]);
				$total=0;
				foreach($_SESSION['carrito']['Productos'] as $producto){
					$total+=$producto['Importe'];
				}
				$_SESSION['carrito']['Total']=$total;
			}
		}
		
		public function guardarPedido($datos){
			$carrito=$this->getCarrito();
			$total=$carrito['Total'];
			$datos=$this->clean($datos);
			extract($datos);
			$user=$_SESSION['user'];
			$this->db->query("
				INSERT INTO pedidos(IdUsuarios,FechaExpedicion,Estatus,Total) 
				VALUES((SELECT IdUsuarios FROM usuarios WHERE Correo='$user'),NOW(),0,$total);
			");
			$header=$this->db->insert_id;
			$this->db->query("
				INSERT INTO envio(Nombre,Apellidos,Correo,Telefono,Pais,Estado,Ciudad,Calle,CodigoPostal,IdPedido) 
				VALUES('$Nombre','$Apellidos','$Correo','$Telefono','$Pais','$Estado','$Ciudad','$Calle','$CodigoPostal',$header)
			");
			foreach($carrito['Productos'] as $producto){
				extract($producto);
				$Nombre=utf8_decode($Nombre);
				$Coleccion=utf8_decode($Coleccion);
				$this->db->query("
					INSERT INTO detallepedido(IdPedido,Producto,Coleccion,Talla,Cantidad,Precio,Importe) 
					VALUES($header,'$Nombre','$Coleccion','$Talla',$Cantidad,$PrecioUnitario,$Importe)
				");
			}
			return true;
		}
		
		public function enviaPedido($plantilla,$datos){
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
			$mail->addAddress($datos['Correo'],$datos['Nombre'].' '.$datos['Apellidos']);
			$mail->addAddress('vestiario@dokorof.com','Vestiario');
			$mail->isHTML(true);
			$mail->Subject='Pedido al vestiario';
			$mail->Body=utf8_decode("Es necesario hacer una transferencia al Banco X con número CLABE Y a la orden de Z para poder disfrutar de tus productos<br/>".$plantilla);
			//echo $mail->ErrorInfo;
			return $mail->send();
		}
	}

?>