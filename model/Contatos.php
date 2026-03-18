<?php
require_once 'Modelbase.php';
class Contatos extends ModelBase {

    /*
    CREATE TABLE IF NOT EXISTS contatos (CREATE TABLE IF NOT EXISTS contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telefone VARCHAR(25) NOT NULL,
    mensagem TEXT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP) 
    */

    public static function save($data) {
        $conn = self::getConnection();
        if (empty($data['id'])) {
            $result = $conn->query("SELECT max(id) as next FROM contatos");
            $row = $result->fetch();
            $data['id'] = (int) $row['next'] + 1;
            $sql = "INSERT INTO contatos (id, nome, email, telefone, mensagem)
            VALUES (:id, :nome, :email, :telefone, :mensagem)";
        } else {
            $sql = "UPDATE contatos SET nome = :nome,
            email = :email,
            telefone = :telefone,
            mensagem = :mensagem
            WHERE id = :id";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefone', $data['telefone']);
        $stmt->bindParam(':mensagem', $data['mensagem']);
        $stmt->execute();
    }

    public static function find($id) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM contatos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     public static function delete($id) {
        $conn = self::getConnection();
        $sql = "DELETE FROM contatos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function all() {
        $conn = self::getConnection();
        $sql = "SELECT * FROM contatos";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}