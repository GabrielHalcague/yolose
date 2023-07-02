<?php
require_once 'helpers/Logger.php';

class MySqlDatabase{
    private $connection;

    public function __construct($serverName, $userName, $password, $databaseName){
        $this->connection = mysqli_connect(
            $serverName,
            $userName,
            $password,
            $databaseName);
        if (!$this->connection) {
            die('Connection failed: ' . mysqli_connect_error());
        }
        mysqli_set_charset($this->connection,'utf8mb4');
    }

    public function __destruct(){
        mysqli_close($this->connection);
    }

    public function query($sql){
       Logger::info('Ejecutando query: ' . $sql);
        $result = mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function query_row($sql){
        Logger::info('Ejecutando query: ' . $sql);
        $result = mysqli_query($this->connection, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function execute($sql){
        Logger::info('Ejecutando query: ' . $sql);
        mysqli_query($this->connection, $sql);
    }
    public function SoloValorCampo($sql){
        Logger::info('Ejecutando query: ' . $sql);
        $result = mysqli_query($this->connection, $sql);
        $valor= mysqli_fetch_row($result);
        if ($valor) {
            return $valor[0];
        } else {
            return null;
        }
    }

}