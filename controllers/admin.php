<?php
	require_once('models/adminmodel.php');
	class Admin extends BaseController{
		public function __construct(){
			$this->model= new AdminModel;
			$this->defaultMethod="productos";
		}
		
		public function productos(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-listar-productos",$datos);
		}
		
		public function usuarios(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-lista-usuarios",$datos);
		}
		
		public function editarProductos(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-edita-productos",$datos);
		}
		
		public function colecciones(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-administra-colecciones",$datos);
		}
		
		public function pedidos(){
			if(!$this->model->loggedIn() || !$this->model->userIsAdmin()){
				$this->redirect("home","mostrarIndice");
			}
			$datos=array("AdminHeader"=>$this->getFilledTemplate('admin-header'));
			echo $this->getFilledTemplate("admin-administra-pedidos",$datos);
		}
	}


?>