<?php
require_once 'Modelbase.php';
class Caracteristicas extends ModelBase {

    protected static $tableName = "caracteristicas" ;

    /*
    CREATE TABLE IF NOT EXISTS caracteristicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    */

    public static function save($data) {
        $conn = self::getConnection();
        if (empty($data['id'])) {
            $result = $conn->query("SELECT max(id) as next FROM caracteristicas");
            $row = $result->fetch();
            $data['id'] = (int) $row['next'] + 1;
            $sql = "INSERT INTO caracteristicas (id, titulo, descricao )
            VALUES (:id, :titulo, :descricao)";
        } else {
            $sql = "UPDATE caracteristicas SET titulo = :titulo,
            descricao = :descricao
            WHERE id = :id";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':descricao', $data['descricao']);
        $stmt->execute();
    }

    public static function find($id) {
        $conn = self::getConnection();
        $sql = "SELECT * FROM caracteristicas WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

     public static function delete($id) {
        $conn = self::getConnection();
        $sql = "DELETE FROM caracteristicas WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

}