<?php

include '../config/Database.php';

class NewsService
{
    private $database;
    public function __construct()
    {
        $this->database = (new Database())->conexao;

    }
    public function createNews($titulo, $conteudo, $imagem, $data_publicacao)
    {
        $stmt = $this->database->prepare("INSERT INTO noticias (titulo, conteudo, imagem, data_publicacao) VALUES(?,?,?,?)");
        $stmt->bind_param("ssss", $titulo, $conteudo, $imagem, $data_publicacao);
        return $stmt->execute();

    }
    public function getAllNews()
    {
        $result = $this->database->query("SELECT * FROM noticias");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNewsById($id)
    {
        $stmt = $this->database->prepare("SELECT * FROM noticias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateNews($id, $titulo, $conteudo, $imagem, $data_publicacao)
    {
        $stmt = $this->database->prepare("UPDATE noticias SET titulo = ?, conteudo = ?, imagem = ?, data_publicacao = ?, WHERE id = ?");
        $stmt->bind_param("issi", $titulo, $conteudo, $imagem, $data_publicacao, $id);
        return $stmt->execute();
    }

    public function deleteNews($id)
    {
        $stmt = $this->database->prepare("DELETE FROM noticias WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>