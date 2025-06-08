<?php
//clase para la conexion

class Conexion{
	
	//declaramos los valores
	private $nombreHost = "localhost";
	private $nombreDB = "bd_apuestas";
	private $usuarioDB = "root";
	private $contrasenaUsuario = "";
   // private $nombreDB = "vaucher";
	//private $usuarioDB = "root";
	//private $contrasenaUsuario = "";
   // 
    
	private $caracter =  "utf8";
	
	//metodo estatico publico para que se conecte.
	function conectar(){
		
		
		$conexion ="mysql:host=".$this->nombreHost.";dbname=".$this->nombreDB.";
		charset=".$this->caracter;
		
		$pdo = new PDO($conexion,$this->usuarioDB, $this->contrasenaUsuario);
		
		return $pdo;
	
		
	}
	
	
}