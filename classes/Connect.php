<?php
class Connect {
    private static $conn;
    public static function getConnection() {
    if (empty(self::$conn)) {
    $conexao = parse_ini_file( 'config/initialize.ini');
    $host = $conexao['host'];
    $name = $conexao['name'];
    $user = $conexao['user'];
    $pass = $conexao['pass'];
    self::$conn = new PDO("mysql:host={$host};dbname={$name};user={$user};password={$pass}");
    self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return self::$conn;
    }  
}