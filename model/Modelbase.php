<?php
require_once 'model/DataBase.php';
abstract class ModelBase extends DataBase {

    protected static $tableName;

    protected static $conn;

    public static function all()
    {
        $conn = self::getConnection();

        $sql = "SELECT * FROM " . static::$tableName;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function find($id) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM  " . static::$tableName . " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



}