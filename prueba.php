<?php 
require_once('mysql.php');
require_once('Producto.php');
	$connection = mysql::factory('mysql');
    $connection->connect();
	$params=array(
					 			
					 );
	$datos = $connection->EjecutarLista("Producto","ObtenerLista",$params);
	
	$dtresultado=new clsListaProducto($datos);

	foreach ($dtresultado->getElementos() as $key => $value) {
		echo "{    Producto => ID : ".$value->getId(). 
			 	", Nombre 	=> ". $value->getNombre(). 
			 	", Precio 	=> ".$value->getPrecio(). "}";
	}

?>