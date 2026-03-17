<?php
abstract class ModelBase {

    protected static $conn;
    
    public static function getConnection()
    {
        $conexao = parse_ini_file('config/initialize.ini');
        $host = $conexao['host'];
        $name = $conexao['name'];
        $user = $conexao['user'];
        $pass = $conexao['pass'];
        self::$conn = new PDO("mysql:dbname={$name};user={$user};host={$host};password={$pass}");
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$conn;
    }

}