<?php
require_once 'Modelbase.php';
require_once './utils/UploadImagem.php';
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

        foreach (['foto', 'imagem_fundo'] as $img) {
            if (!empty($data[$img])) {
                $stmt->bindParam(":$img", $data[$img]);
                UploadImagem::deleteImage(self::class,$data['id'], $img);
            }
        }
        
        $stmt->execute();
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
        UploadImagem::deleteImage(self::class, $id, 'foto');
        UploadImagem::deleteImage(self::class, $id, 'imagem_fundo');
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