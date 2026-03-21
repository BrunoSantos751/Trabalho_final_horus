<?php
require_once 'Modelbase.php';

class Aplicativo extends ModelBase {

    protected static $tableName = "aplicativos";

    public static function save($data) {
        $conn = self::getConnection();

        if (empty($data['id'])) {
            $sql = "INSERT INTO aplicativos (titulo, descricao, icon)
                    VALUES (:titulo, :descricao, :icon)";
        } else {
            $sql = "UPDATE aplicativos SET 
                    titulo = :titulo,
                    descricao = :descricao,
                    icon = :icon
                    WHERE id = :id";
        }

        $stmt = $conn->prepare($sql);

        if (!empty($data['id'])) {
            $stmt->bindParam(':id', $data['id']);
        }

        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':descricao', $data['descricao']);
        $stmt->bindParam(':icon', $data['icon']);

        $stmt->execute();
    }

    public static function delete($id) {
        $conn = self::getConnection();
        $stmt = $conn->prepare("DELETE FROM aplicativos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}