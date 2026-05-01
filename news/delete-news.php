<?php

include 'NewsService.php';

session_start();

$newsService = new NewsService();

$listNewsPageLink = "/projeto-final/news/list-news-manager.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: $listNewsPageLink");
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    ;

    if ($newsService->deleteNews($id)) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Noticia removida com sucesso.'];
    } else {
        $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Noticia nao encontrada ou ja removida.'];
    }
} else {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Invalid request.'];
}

header("Location: $listNewsPageLink");
exit;
