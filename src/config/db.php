<?php

    class db{
        private $dbHost = 'localhost';
        private $dbUser = 'root';
        private $dbPass = '';
        private $dbName = 'apirest';
    

    public function conectar(){
        $conexion_mysql = "mysql:host=$this->dbHost;dbname=$this->dbName";
        $conexionBD = new PDO($conexion_mysql, $this->dbUser, $this->dbPass);
        $conexionBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conexionBD;
    }
}
?>