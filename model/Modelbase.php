<?php
abstract class ModelBase {

    protected static $pdo;
    
    public static function getConnection()
    {
        $conexao = parse_ini_file('config/initialize.ini');
        $host = $conexao['host'];
        $name = $conexao['name'];
        $user = $conexao['user'];
        $pass = $conexao['pass'];
        self::$pdo = new PDO("mysql:dbname={$name};user={$user};host={$host};password={$pass}");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$pdo;
    }

}