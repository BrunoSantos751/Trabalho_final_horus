<?php
abstract class ModelBase {

    protected static $tableName;

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

    public static function all()
    {
        $conn = self::getConnection();

        $sql = "SELECT * FROM " . static::$tableName;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    protected static function find($id) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM ". static::$tableName ." WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



}