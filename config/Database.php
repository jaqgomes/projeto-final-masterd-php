<?php
class Database
{

    private $host = "localhost";
    private $dbname = "sistema_web";
    private $username = "root";
    private $password = "";

    public $conexao;

    public function __construct()
    {
        $this->conexao = null;
        $this->conexao = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->conexao->connect_error) {

            die("Connection failed: " . $this->conexao->connect_error);
        }
    }

}

?>