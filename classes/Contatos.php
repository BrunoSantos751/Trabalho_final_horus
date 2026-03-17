<?php
class Contatos {

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
        $conn = Connect::getConnection();
        if (empty($data['id'])) {
            $result = $conn->query("SELECT max(id) as next FROM contatos");
            $row = $result->fetch();
            $data['id'] = (int) $row['next'] + 1;
            $sql = "INSERT INTO contatos (id, nome, email, telefone, mensagem)
            VALUES ( '{$data['id']}', '{$data['nome']}',
            '{$data['email']}', '{$data['telefone']}',
            '{$data['mensagem']}')";
        } else {
            $sql = "UPDATE contatos SET nome = '{$data['nome']}',
            email = '{$data['email']}',
            telefone = '{$data['telefone']}',
            mensagem = '{$data['mensagem']}'
            WHERE id = '{$data['id']}'";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':telefone', $data['telefone']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':endereco', $data['endereco']);
        $stmt->execute();
    }

    public static function find($id) {
        $conn = Connect::getConnection();
        $sql = "SELECT * FROM contatos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     public static function delete($id) {
        $conn = Connect::getConnection();
        $sql = "DELETE FROM contatos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

}