<?php
	require_once('models/productosmodel.php');
	class Productos extends BaseController{
		public function __construct(){
			$this->model= new ProductosModel;
			$this->defaultMethod="listar";
		}
		
		public function listar(){
			$coleccion=array();
			if(!isset($_GET['id']))
				$coleccion=$this->model->listar();
			else if($this->validate($_GET['id'],"int")){
				$coleccion=$this->model->listar($_GET['id']);
			}
				
			$productos_string="";
			if(isset($coleccion['Productos'])){
				foreach($coleccion['Productos'] as $nombre=>$opciones){
					$datos=array(
						"@@NombreProducto@@"=>$nombre,
						"@@IdProducto@@"=>$opciones['id'],
						"@@PrecioProducto@@"=>$opciones['Precio'],
						"@@ImagenProducto@@"=>$opciones['img']
					);
					$producto_coleccion_view=$this->getFilledTemplate('producto_coleccion',$datos);
					$productos_string.=$producto_coleccion_view;
				}
			}
			if(count($coleccion['Productos'])==0)
				$coleccion=array("Coleccion_Titulo"=>"No se encontraron resultados");
			$datos=array(
				"@@Title@@"=>$coleccion['Coleccion_Titulo'],
				"@@ListaProductos@@"=>$productos_string,
				"@@Footer@@"=>$this->getFilledTemplate('footer'),
				"@@Header@@"=>$this->getHeader()
			);
			echo $this->getFilledTemplate('coleccion',$datos);
		}
		public function listarHombre(){
			$coleccion=$this->model->listarHombre();
			$productos_string="";
			if(isset($coleccion['Productos'])){
				foreach($coleccion['Productos'] as $nombre=>$opciones){
					$datos=array(
						"@@NombreProducto@@"=>$nombre,
						"@@IdProducto@@"=>$opciones['id'],
						"@@PrecioProducto@@"=>$opciones['Precio'],
						"@@ImagenProducto@@"=>$opciones['img']
					);
					$producto_coleccion_view=$this->getFilledTemplate('producto_coleccion',$datos);
					$productos_string.=$producto_coleccion_view;
				}
			}
			if(count($coleccion['Productos'])==0)
				$coleccion=array("Coleccion_Titulo"=>"No se encontraron resultados");
			$datos=array(
				"@@Title@@"=>$coleccion['Coleccion_Titulo'],
				"@@ListaProductos@@"=>$productos_string,
				"@@Footer@@"=>$this->getFilledTemplate('footer'),
				"@@Header@@"=>$this->getHeader()
			);
			echo $this->getFilledTemplate('coleccion_genero',$datos);
		}
		public function listarMujer(){
			$coleccion=$this->model->listarMujer();
			$productos_string="";
			if(isset($coleccion['Productos'])){
				foreach($coleccion['Productos'] as $nombre=>$opciones){
					$datos=array(
						"@@NombreProducto@@"=>$nombre,
						"@@IdProducto@@"=>$opciones['id'],
						"@@PrecioProducto@@"=>$opciones['Precio'],
						"@@ImagenProducto@@"=>$opciones['img']
					);
					$producto_coleccion_view=$this->getFilledTemplate('producto_coleccion',$datos);
					$productos_string.=$producto_coleccion_view;
				}
			}
			if(count($coleccion['Productos'])==0)
				$coleccion=array("Coleccion_Titulo"=>"No se encontraron resultados");
			$datos=array(
				"@@Title@@"=>$coleccion['Coleccion_Titulo'],
				"@@ListaProductos@@"=>$productos_string,
				"@@Footer@@"=>$this->getFilledTemplate('footer'),
				"@@Header@@"=>$this->getHeader()
			);
			echo $this->getFilledTemplate('coleccion_genero',$datos);
		}
		
		public function detalleProducto(){
			if($this->validate($_GET['id'],"int")){
				$producto=$this->model->detalleProducto($_GET['id']);
				if(count($producto)==0)
					$this->show404();
				else{
					$datos=array(
						"@@ProductoNombre@@"=>$producto['Nombre'],
						"@@ProductoPrecio@@"=>$producto['Precio'],
						"@@ProductoImgGrande@@"=>$producto['ImgGrande'],
						"@@ProductoImg1@@"=>$producto['Img1'],
						"@@ProductoImg2@@"=>$producto['Img2'],
						"@@ProductoImg3@@"=>$producto['Img3'],
						"@@ProductoDescripcion@@"=>$producto['Descripcion'],
						"@@Header@@"=>$this->getHeader(),
						"@@Footer@@"=>$this->getFilledTemplate('footer')
					);
					echo $this->getFilledTemplate('detalle-producto',$datos);
				}
			}
				
			else
				$this->show404();
		}
	}

?>