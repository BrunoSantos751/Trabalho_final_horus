<?php
require_once 'Modelbase.php';
class Usuarios extends ModelBase{

    protected static $tableName = "usuarios";

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

            $email = $_POST['email'];
            $password = $_POST['password'] ?? null;

            $hash = null;
            if (!empty($password)) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
            }

            if (isset($_POST['id']) && !empty($_POST['id'])) {


                if ($hash !== null) {
                    $sql = "UPDATE usuarios SET email = :email, password = :password WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':password', $hash);
                } else {
                    $sql = "UPDATE usuarios SET email = :email WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                }
                
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':id', $_POST['id']);
                $stmt->execute();
                return;
            }

            if ($hash === null) {
                throw new Exception("Senha obrigatória para novo usuário.");
            }

            $sql = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hash);
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
            throw new Exception("Não é permitido deletar o usuário admin.");
        }
        $conn = self::getConnection();
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return "Usuário deletado com sucesso.";
    }

}