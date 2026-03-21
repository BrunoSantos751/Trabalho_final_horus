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

        public static function save($data = null) {
            $data = $data ?? $_POST;
            if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
                throw new Exception("Acesso negado. Apenas o administrador pode realizar esta operação.");
            }
            

            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;
            
            self::validation_format($email, $password);

            $hash = null;
            if ($password !== null && $password !== '') {
                $hash = password_hash($password, PASSWORD_DEFAULT);
            }

            $conn = self::getConnection();

            $id = $data['id'] ?? null;


            if ($id) {
                $stmt = $conn->prepare("
                    SELECT id FROM usuarios 
                    WHERE email = :email AND id != :id 
                    LIMIT 1
                ");
                $stmt->execute([
                    'email' => $email,
                    'id' => $id
                ]);
            } else {
                $stmt = $conn->prepare("
                    SELECT id FROM usuarios 
                    WHERE email = :email 
                    LIMIT 1
                ");
                $stmt->execute([
                    'email' => $email
                ]);
            }

            if ($stmt->fetch()) {
                throw new Exception("Email já está em uso");
            }

            if ($id) {
                if ($hash !== null) {
                    $sql = "UPDATE usuarios SET email = :email, password = :password WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':password', $hash);
                } else {
                    $sql = "UPDATE usuarios SET email = :email WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                }
                
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':id', $id);
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

    private static function validation_format($email, $password = null)
    {
        if ($email === null || $email === '') {
            throw new Exception("Email obrigatório");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email inválido");
        }

        if ($password !== null && $password !== '') {
            $validPassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

            if (!preg_match($validPassword, $password)) {
                throw new Exception("Senha fraca");
            }
        }
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