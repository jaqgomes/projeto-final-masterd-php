<?php

require_once __DIR__ . '../../config/Database.php';

class SecurityService
{
    private $database;

    public function __construct()
    {
        $this->database = (new Database())->conexao;
    }

    public function registerUser($nome, $apelido, $email, $telefone, $username, $password)
    {
        $stmt = $this->database->prepare("SELECT id from utilizadores WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        if ($stmt->fetch()) {
            return 'Este nome de usuario é invalido!';
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->database->prepare("INSERT INTO utilizadores (nome, apelido, email, telefone, username, password) VALUES(?,?,?,?,?,?)");
        $stmt->bind_param("ssssss", $nome, $apelido, $telefone, $email, $username, $password_hash);
        $stmt->execute();
        return true;

    }

    public function loginUser($username, $password)
    {
        $stmt = $this->database->prepare("SELECT id, nome, password FROM utilizadores where username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if (!$user || !password_verify($password, $user['password'])) {
            return 'Login Invalido.';
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['password'] = $user['password'];

        return true;

    }
}
?>