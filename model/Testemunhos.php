<?php
class Testemunhos {

    /*
    CREATE TABLE IF NOT EXISTS testemunhos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cargo VARCHAR(255) NOT NULL,
    depoimento TEXT NOT NULL,
    imagem VARCHAR(255) NOT NULL
    */

    public static function save($testemunho) {
        $conn = Connect::getConnection();
        if (empty($testemunho['id'])) {
            $result = $conn->query("SELECT max(id) as next FROM testemunhos");
            $row = $result->fetch();
            $testemunho['id'] = (int) $row['next'] + 1;
            $sql = "INSERT INTO testemunhos (id, nome, cargo, depoimento, imagem)
            VALUES ( '{$testemunho['id']}', '{$testemunho['nome']}',
            '{$testemunho['cargo']}', '{$testemunho['depoimento']}',
            '{$testemunho['imagem']}')";
        } else {
            $sql = "UPDATE testemunhos SET nome = '{$testemunho['nome']}',
            cargo = '{$testemunho['cargo']}',
            depoimento = '{$testemunho['depoimento']}',
            imagem = '{$testemunho['imagem']}'
            WHERE id = '{$testemunho['id']}'";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->bindParam(':nome', $testemunho['nome']);
        $stmt->bindParam(':cargo', $testemunho['cargo']);
        $stmt->bindParam(':depoimento', $testemunho['depoimento']);
        $stmt->bindParam(':imagem', $testemunho['imagem']);
        $stmt->execute();
    }

    public static function find($id) {
        $conn = Connect::getConnection();
        $sql = "SELECT * FROM testemunhos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     public static function delete($id) {
        $conn = Connect::getConnection();
        $sql = "DELETE FROM testemunhos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function all() {
        $conn = Connect::getConnection();
        $sql = "SELECT * FROM testemunhos";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}