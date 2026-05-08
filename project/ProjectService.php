<?php

include '../config/Database.php';

class ProjectService
{
    private $database;

    public function __construct()
    {
        $this->database = (new Database())->conexao;
    }

    //este metodo insere um novo registro na tabela projetos usando prepared;criando uma prepared que é uma query segura; (?)sao placeholders
    //que serão substituidos pelos valores reais(ou seja, todos os campos seraoo tratados como texto);
    //executa uma query no banco de dados ($stmt);
    //utilizado quando na criacao de projetos, depois de validar os dados, depois de fazer upload da imagem

    public function createProject($nome_projeto, $descricao, $tecnologia, $tempo_conclusao, $fotografia)
    {
        $stmt = $this->database->prepare("INSERT INTO projetos (nome_projeto, descricao, tecnologia, tempo_conclusao, fotografia) VALUES(?,?,?,?,?)");
        $stmt->bind_param("sssss", $nome_projeto, $descricao, $tecnologia, $tempo_conclusao, $fotografia);
        return $stmt->execute();

    }
    //este metodo faz executa uma query no SQL(busca todos registros na tabela projetos),coverte tudo em array;
    public function getAllProjects()
    {
        $result = $this->database->query("SELECT * FROM projetos");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    //o metodo getProjectId buscar um projeto pelo ID usando prepared statements
    //onde ? sera substituido pelo ID
    public function getProjectById($id)
    {
        $stmt = $this->database->prepare("SELECT * FROM projetos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    //esse metodo atualiza o banco de dados , substituindo pelo que enviar. Apenas com valor do ID que passar 
    public function updateProject($id, $nome_projeto, $descricao, $tecnologia, $tempo_conclusao, $fotografia)
    {
        $stmt = $this->database->prepare("UPDATE projetos SET nome_projeto = ?, descricao = ?, tecnologia = ?, tempo_conclusao = ?, fotografia = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $nome_projeto, $descricao, $tecnologia, $tempo_conclusao, $fotografia, $id);
        return $stmt->execute();

    }
    //prepara a query SQL, apaga o projeto cujo ID corresponder ao valor enviado
    public function deleteProject($id)
    {
        $stmt = $this->database->prepare("DELETE FROM projetos WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>