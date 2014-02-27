<?php

class mysql
{
	protected static $instance = null;
	protected $link;
    
    public $user = "";
    public $pass = "";
    public $host = "";
    public $db = "";
	
	public static function factory($type)
	{
		return call_user_func(array($type,'getInstance'));
	}

	public static function getInstance()
	{
		if(is_null(self::$instance)){
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function getLink(){
		return $this->link;
	}

	protected function __construct()
	{
		global $config;
		$_bd   = "bdprueba";
		$_user = "root";
		$_pass = "";
		$_host = "localhost";
		if($this->user == "")
		{
			$this->user =$_user;
		}
        if($this->pass == "")
		{
			$this->pass =$_pass;
		}
		if($this->host == "")
		{
			$this->host =$_host;
		}
		if($this->db == "")
		{
			$this->db =$_bd;
		}
		
	}
    
	public function connect(){
    	$this->link = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass);
		$this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->link->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
	
	public function getArray($query)
	{
		try{
          $result = $this->link->query($query);
		  $return = array();

	      if($result){
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $return[] = $row;
			}
			
		   }
		  return $return;
		}
		catch(PDOException $ex){
             $this->MostrarMensaje($ex->getMessage());
		}
		
	}
	
    public function getNumRows($query){
    	
        $result = $this->link->query($query);
        $row_count = $result->rowCount();
        return $row_count;
    }

    public function EjecutarComando($entidad,$metodo,$parametros){
    	$cadena = "CALL " .$entidad."_".$metodo."_pa(";

    	foreach ($parametros as $key => $value) {
    			$cadena = $cadena."$key".",";
    	}

	   	$cadena=substr($cadena,0,-1);  
    	$cadena = $cadena.");";	
 		
     
        $result = $this->link->prepare($cadena);
      
		  $affected_rows = $result->execute($parametros);
		  //return $affected_rows;
		  $idvalor = 0;
		 while ($fila = $result->fetch()) {
       		$idvalor = $fila[0];
    	}
    	return $idvalor;
    }

    public function EjecutarLista($entidad,$metodo,$parametros){
    	$cadena = "CALL " .$entidad."_".$metodo."_pa(";
    	if(count($parametros)!=0){
    		foreach ($parametros as $key => $value) {
    			$cadena = $cadena."$key".",";
    		}

			$cadena=substr($cadena,0,-1);
    	}
    	  
    	$cadena = $cadena.");";	
 		
    	$result = $this->link->prepare($cadena);
		$result->execute($parametros);
		
		$p=array();
		while ($fila = $result->fetch()) {
       		$p[]=$fila;

    	}
    	return $p;
    	
    }

     public function EjecutarRegistro($entidad,$metodo,$parametros){
    	$cadena = "CALL " .$entidad."_".$metodo."_pa(";
    	if(count($parametros)!=0){
    		foreach ($parametros as $key => $value) {
    			$cadena = $cadena."$key".",";
    		}

			$cadena=substr($cadena,0,-1);
    	}
    	  
    	$cadena = $cadena.");";	
 		
    	$result = $this->link->prepare($cadena);
		$result->execute($parametros);
		
		$p=array();
		 $count=0;
		while ($fila = $result->fetch()) {
       		$p[]=$fila;
       		 $count=$count+1;

    	}
    	if($count==1)
        	return $p[0];
      	else
        	return null;
    	
    }

	public function execute($query,$params)
	{
		$result = $this->link->prepare($query);
		$affected_rows = $result->execute($params);
		//return $affected_rows;
		$idvalor = 0;
		 while ($fila = $result->fetch()) {
       
       
       		$idvalor = $fila[0];
    	}
    	return $idvalor;
	}

}
?>