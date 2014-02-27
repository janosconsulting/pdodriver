<?php
class clsProducto
{
	public $id;
	public $nombre;
	public $precio;

	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function setNombre($nombre){
		$this->nombre=$nombre;
	}

	public function getPrecio(){
		return $this->precio;
	}
	public function setPrecio($precio){
		$this->precio=$precio;
	}
	public function __construct($dr=array()){
		
		if($dr!=null){
			if(array_key_exists('id', $dr))	$this->setId($dr["id"]);
			if(array_key_exists('nombre', $dr))	$this->setNombre($dr["nombre"]);
			if(array_key_exists('precio', $dr))	$this->setPrecio($dr["precio"]);
		
		}
	}
}
class clsListaProducto
{
	private $objelementos=array();
	public function getElementos(){
		return $this->objelementos;
	}
	public function setElementos($objeto=array()){
		$this->objelementos[]=new clsProducto($objeto);
	}
	public function __construct($entidad=array()){
		if($entidad==null){ return; }
		foreach($entidad as $objeto)
			$this->setElementos($objeto);
	}
}

