<?php
require_once __DIR__ . '/../model/Modelbase.php';
class Usuarios extends ModelBase{

    /*
    CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    */

    public static function save() {
        $conn = self::getConnection();
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            $sql = "UPDATE usuarios SET email = :email, password = :password WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':password', $_POST['password']);
            $stmt->bindParam(':id', $_POST['id']);
            $stmt->execute();
            return;
        }   
        $sql = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->execute();
    }

    public static function find($id) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($id) {
        $conn = self::getConnection();
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function all() {
        $conn = self::getConnection();
        $sql = "SELECT * FROM usuarios";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}