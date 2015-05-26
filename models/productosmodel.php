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
					$listaProductosColecciones["Productos"][$row["Nombre"]]=array("Precio"=>$row["Precio"],"img"=>$row["Imagen1"],"id"=>$row["IdProducto"]);
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
					$listaProductosColecciones["Productos"][$row["Nombre"]]=array("Precio"=>$row["Precio"],"img"=>$row["Imagen1"],"id"=>$row["IdProducto"]);
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
					$listaProductosColecciones["Productos"][$row["Nombre"]]=array("Precio"=>$row["Precio"],"img"=>$row["Imagen1"],"id"=>$row["IdProducto"]);
				}
			}
			return $listaProductosColecciones;
		}
		
		public function detalleProducto($id){
			$id=$this->cleanSingle($id);
			$result=$this->db->query("SELECT * FROM producto WHERE IdProducto=$id");
			$datos=array();
			if(is_object($result) && $result->num_rows>0){
				$row=$result->fetch_assoc();
				$datos=array(
					"Nombre"=>$row['Nombre'],
					"Precio"=>$row['Precio'],
					"Descripcion"=>$row['Descripcion'],
					"Img1"=>"prenda.png",
					"Img2"=>"prenda.png",
					"Img3"=>"prenda.png",
					"ImgGrande"=>"prendagrande.png"
				);
			}
			return $datos;
		}
		
		public function tallas($id){
			$result=$this->db->query("SELECT * FROM tallas WHERE IdTallas IN (SELECT IdTalla FROM vinculaciontallas WHERE IdProducto=$id)");
			if(is_object($result) && $result->num_rows>0)
				return $result->fetch_all(MYSQLI_ASSOC);
			return array();
		}
	}
?>