<?php
require_once __DIR__ . '/../security/SessionService.php';
include('ProjectService.php');

$projectService = new ProjectService();

session_start();
SessionService::isRequireLogin();

$projectService = new ProjectService();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$project = $projectService->getProjectById($id);

if (!$project) {
    http_response_code(404);
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Project not found.'];
    header('Location: /projeto-final/project/list-project-manager.php');
}

//metodo usado para validar e converter data para exibir na tela

if (!empty($project['tempo_conclusao'])) {
    $dateObj = new DateTime($project['tempo_conclusao']);
    $date = $dateObj->format('Y-m-d');
}

$pageTitle = 'Edit Project - Web System';
$errors = [];
$input = $project;
$input['date'] = $date ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input['nome_projeto'] = trim($_POST['nome_projeto'] ?? '');
    $input['descricao'] = trim($_POST['descricao'] ?? '');
    $input['tecnologia'] = trim($_POST['tecnologia'] ?? '');
    $input['tempo_conclusao'] = trim($_POST['tempo_conclusao'] ?? '');

    if ($input['nome_projeto'] === '') {
        $errors['nome_projeto'] = 'Nome do projeto é obrigatório. ';
    }

    if (!empty($_POST['remover_fotografia']) && !empty($project['fotografia'])) {

        $caminho = __DIR__ . '/uploads' . $project['fotografia'];

        if (file_exists($caminho)) {
            unlink($caminho);
        }

        $input['fotografia'] = null;

    } elseif (!empty($_FILES['fotografia']['name'])) {

        $file = $_FILES['fotografia'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['fotografia'] = 'Erro ao enviar a fotografia.';

        } else {
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($file['type'], $allowed)) {
                $errors['fotografia'] = 'A fotografia deve ser JPEG, PNG e WEBP.';
            }
        }

        $input['fotografia'] = uniqid() . '-' . basename($_FILES['fotografia']['name']);
        $destino = __DIR__ . '/uploads/' . $input['fotografia'];

        move_uploaded_file($_FILES['fotografia']['tmp_name'], $destino);

    } else {
        $input['fotografia'] = $project['fotografia'];
    }

    if (empty($errors)) {
        $projectService->updateProject(
            $id,
            $input['nome_projeto'],
            $input['descricao'],
            $input['tecnologia'],
            $input['tempo_conclusao'],
            $input['fotografia']
        );

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Projeto alterado com sucesso!'];
        header('Location: /projeto-final/project/list-project-manager.php');
        exit;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>


<div class="row justify-content-center">
    <div class="col-lg-7">
        <h2 class="page-header">Edit Project</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Please fix the errors below.
            </div>

        <?php endif; ?>

        <div class="card form-card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Project Details
            </div>
            <div class="card-body p-4">
                <form method="POST" action="/projeto-final/project/edit-project.php?id=<?= $id ?>" novalidate
                    enctype="multipart/form-data">

                    <?php include __DIR__ . '/project-details.html'; ?>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="/projeto-final/project/list-project-manager.php" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-save me-1"></i>
                            Update News
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.html'; ?>