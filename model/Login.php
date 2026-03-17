<?php
require_once __DIR__ . '/../model/Modelbase.php';
class Login extends ModelBase {
    
    private $request;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function login() {
        $email = $this->request['email'] ?? null;
        $password = $this->request['password'] ?? null;

        if (empty($email) || empty($password)) {
            exit("Email e senha são obrigatórios");
        }

        $sql = "SELECT * FROM usuarios WHERE email = :email AND password = :password";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email, 'password' => $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        var_dump($user);

        if ($user) {
            var_dump($user);
            //$_SESSION['user'] = $user;
        } else {
            echo "Email ou senha incorretos.";
        }
    }

    function logout() {
        session_destroy();
    }

}