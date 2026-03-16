<?php
class UserLogin {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login bem-sucedido
            return true;
        } else {
            // Login falhou
            return false;
        }
    }
}