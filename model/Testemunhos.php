<?php
require_once 'Modelbase.php';
class Testemunhos extends ModelBase {

    /*
    CREATE TABLE IF NOT EXISTS testemunhos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        funcao VARCHAR(255) NOT NULL,
        titulo VARCHAR(255) NOT NULL,
        descricao TEXT NOT NULL,
        foto VARCHAR(255) NOT NULL,
        imagem_fundo VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB 
    DEFAULT CHARSET=utf8mb4 
    COLLATE=utf8mb4_unicode_ci;
    */

    public static function save($data) {
        $conn = self::getConnection();
        if (empty($data['id'])) {
            $result = $conn->query("SELECT max(id) as next FROM testemunhos");
            $row = $result->fetch();
            $data['id'] = (int) $row['next'] + 1;
            $sql = "INSERT INTO testemunhos (id, nome, funcao, titulo, descricao, foto, imagem_fundo ) VALUES (:id, :nome, :funcao, :titulo, :descricao, :foto, :imagem_fundo)";
        } else {
            $sql = "UPDATE testemunhos SET nome = :nome,
            funcao = :funcao,
            titulo = :titulo,
            descricao = :descricao" . (!empty($data['foto']) ? ", foto = :foto" : "") .
            (!empty($data['imagem_fundo']) ? ", imagem_fundo = :imagem_fundo" : "") .
             " WHERE id = :id";         
        }
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':funcao', $data['funcao']);
        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':descricao', $data['descricao']);
        if (!empty($data['foto'])) {
            $stmt->bindParam(':foto', $data['foto']);
            Testemunhos::deleteImage($data['id'], 'foto');
        }
        if (!empty($data['imagem_fundo'])) {
            $stmt->bindParam(':imagem_fundo', $data['imagem_fundo']);
            Testemunhos::deleteImage($data['id'], 'imagem_fundo');
        }
        $stmt->execute();
    }

    public static function deleteImage($id, $field) {
        $testemunho = self::find($id);
        if ($testemunho) {
            if ($field === 'foto' && !empty($testemunho['foto']) && file_exists($testemunho['foto'])) {
                unlink($testemunho['foto']);
            }
            if ($field === 'imagem_fundo' && !empty($testemunho['imagem_fundo']) && file_exists($testemunho['imagem_fundo'])) {
                unlink($testemunho['imagem_fundo']);
            }
        }
    }

    public static function find($id) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM testemunhos WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     public static function delete($id) {
        $conn = self::getConnection();
        $sql = "DELETE FROM testemunhos WHERE id = :id";
        Testemunhos::deleteImage($id, 'foto');
        Testemunhos::deleteImage($id, 'imagem_fundo');
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function all() {
        $conn = self::getConnection();
        $sql = "SELECT * FROM testemunhos";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}