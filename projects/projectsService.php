<?php

include 'config/Database.php';

class ProjectsService
{
    private $database;

    public function __construct()
    {
        $this->database = (new Database())->conexao;
    }
    public function createProjects($nome_projeto, $descricao, $tecnologia, $tempo_conslusao, $fotografia)
    {
       $stmt = $this->database->prepare("INSERT INTO consultas (nome_projeto, descricao, tecnologia, tempo_conslusao, fotografia) VALUES(?,?,?,?,?)""
    }
}
?>