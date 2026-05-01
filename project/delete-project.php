<?php

include 'ProjectService.php';

session_start();

$projectService = new ProjectService();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /projeto-final/project/list-project-manager.php');
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    ;

    if ($projectService->deleteProjects($id)) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Projeto removido com sucesso.'];
    } else {
        $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Projeto nao encontrado ou ja removido.'];
    }
} else {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Invalid request.'];
}

header('Location: /projeto-final/project/list-project-manager.php');
exit;
