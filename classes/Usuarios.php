<?php
class Usuarios{

    /*
    CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    */

    public static function save($data) {
        $conn = Connect::getConnection();
        $sql = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $stmt->execute();
    }

    public static function authenticate($email, $password) {
        $conn = Connect::getConnection();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }

    public static function find($id) {
        $conn = Connect::getConnection();
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function delete($id) {
        $conn = Connect::getConnection();
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

}