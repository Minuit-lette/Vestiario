<?php
	require_once('controllers/basecontroller.php');
	if(!isset($_GET['ctl']) && !isset($_GET['act'])){
		require_once('controllers/home.php');
		$controlador=new Home;
	}
	else if(isset($_GET['ctl']) && is_file('controllers/'.$_GET['ctl'].'.php') && ('controllers/'.$_GET['ctl'].'.php')!=('controllers/basecontroller.php')){
		require_once('controllers/'.$_GET['ctl'].'.php');
		$controlador_nombre=ucfirst($_GET['ctl']);
		$controlador=new $controlador_nombre();
	}
	else{
		require_once('controllers/siteerror.php');
		$controlador=new SiteError;
	}
	$controlador->run();

?>