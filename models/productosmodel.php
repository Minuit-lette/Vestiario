<?php
	class ProductosModel extends BaseModel{
		/*public function __construct(){
			parent::__construct();
		}*/
		public function listar($id=null){
			$sql="SELECT * FROM producto";
			if($id!=null)
				$id=$this->cleanSingle($id);
			$sql.=($id==null)? "":" WHERE Coleccion=$id";
			$result=$this->db->query($sql);
			$listaProductosColecciones=array(
				"Coleccion_Titulo"=>"Todos",
				"Productos"=>array()
			);
			if(is_object($result)){
				$rows=$result->fetch_all(MYSQLI_ASSOC);
				foreach($rows as $row){
					$listaProductosColecciones["Productos"][$row["Nombre"]]=array("Precio"=>$row["Precio"],"img"=>$row["Imagen"],"id"=>$row["IdProducto"]);
				}
			}
			return $listaProductosColecciones;
		}
		
		public function listarHombre(){
			$sql="SELECT * FROM producto WHERE Coleccion IN (SELECT IdColecciones FROM colecciones WHERE Categoria='H')";
			$result=$this->db->query($sql);
			$listaProductosColecciones=array(
				"Coleccion_Titulo"=>"Productos para hombre",
				"Productos"=>array()
			);
			if(is_object($result)){
				$rows=$result->fetch_all(MYSQLI_ASSOC);
				foreach($rows as $row){
					$listaProductosColecciones["Productos"][$row["Nombre"]]=array("Precio"=>$row["Precio"],"img"=>$row["Imagen"],"id"=>$row["IdProducto"]);
				}
			}
			return $listaProductosColecciones;
		}
		
		public function listarMujer(){
			$sql="SELECT * FROM producto WHERE Coleccion IN (SELECT IdColecciones FROM colecciones WHERE Categoria='M')";
			$result=$this->db->query($sql);
			$listaProductosColecciones=array(
				"Coleccion_Titulo"=>"Productos para mujer",
				"Productos"=>array()
			);
			if(is_object($result)){
				$rows=$result->fetch_all(MYSQLI_ASSOC);
				foreach($rows as $row){
					$listaProductosColecciones["Productos"][$row["Nombre"]]=array("Precio"=>$row["Precio"],"img"=>$row["Imagen"],"id"=>$row["IdProducto"]);
				}
			}
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