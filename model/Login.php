<?php
session_start();
require_once 'DataBase.php';
class Login extends DataBase {
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

public static function login($data = null) {
    $data = $data ?? $_POST;

    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    if (empty($email) || empty($password)) {
        exit("Email e senha são obrigatórios");
    }

    $conn = self::getConnection();

    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Email ou senha incorretos.";
        return false;
    }

    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_login'] = (bool) $user['first_login'];
        return true;
    }

    echo "Email ou senha incorretos.";
    return false;
}

    public static function logout() {
        session_destroy();
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

}
