<?php
require_once 'Modelbase.php';
class Usuarios extends ModelBase{

    /*
    CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    */

    public static function save() {
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            throw new Exception("Acesso negado. Apenas o administrador pode realizar esta operação.");
        }
        $conn = self::getConnection();
        if (isset($_POST['id']) && !empty($_POST['id'])) {
            if ( $_POST['password']) {
                $sql = "UPDATE usuarios SET email = :email, password = :password WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':email', $_POST['email']);
                $stmt->bindParam(':password', $_POST['password']);
                $stmt->bindParam(':id', $_POST['id']);
                $stmt->execute();
                return;
            }
            $sql = "UPDATE usuarios SET email = :email WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $_POST['email']);
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
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
            throw new Exception("Acesso negado. Apenas o administrador pode realizar esta operação.");
        }
        if ($id == 1) {
            return "Não é permitido deletar o usuário admin.";
        }
        $conn = self::getConnection();
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return "Usuário deletado com sucesso.";
    }

    public static function all() {
        $conn = self::getConnection();
        $sql = "SELECT * FROM usuarios";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}