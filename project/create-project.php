<?php
require_once __DIR__ . '/../security/SessionService.php';

include('ProjectService.php');

$projectService = new ProjectService();

session_start();
SessionService::isRequireLogin();
$listProjectPageLink = "/projeto-final/project/list-project-manager.php";

$pageTitle = "Add project - Web System";
$errors = [];
$input = ['nome_projeto' => '', 'descricao' => '', 'tecnologia' => '', 'tempo_conclusao' => '', 'fotografia' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input['nome_projeto'] = trim($_POST['nome_projeto'] ?? '');
    $input['descricao'] = trim($_POST['descricao'] ?? '');
    $input['tecnologia'] = trim($_POST['tecnologia'] ?? '');
    $input['tempo_conclusao'] = trim($_POST['tempo_conclusao'] ?? '');

    if ($input['nome_projeto'] === '') {
        $errors['nome_projeto'] = 'Nome do Projeto é obrigatorio';
    }

    if ($input['tempo_conclusao'] === '') {
        $input['tempo_conclusao'] = null;
    }

    if (!empty($_FILES['fotografia']['name'])) {
        $file = $_FILES['fotografia'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['fotografia'] = 'Erro ao enviar a imagem.';

        } else {
            //$allowed = ['fotografia/jpeg', 'fotografia/png', 'fotografia/webp'];
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($file['type'], $allowed)) {
                $errors['fotografia'] = 'A fotografia deve ser JPEG, PNG ou WEBP.';
            }
        }

        $input['fotografia'] = uniqid() . '-' . basename($_FILES['fotografia']['name']);
        $destino = __DIR__ . '/uploads/' . $input['fotografia'];

        move_uploaded_file($_FILES['fotografia']['tmp_name'], $destino);

    } else {
        $input['fotografia'] = null;
    }

    if (empty($errors)) {

        $projectService->createProject(
            $input['nome_projeto'],
            $input['descricao'],
            $input['tecnologia'],
            $input['tempo_conclusao'],
            $input['fotografia']

        );

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Projeto Adicionado com Sucesso!'];
        header("Location: $listProjectPageLink");
        exit;
    }
}
require_once __DIR__ . '/../includes/header.php';

?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <h2 class="page-header">Add project</h2>

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
                <form method="POST" action="/projeto-final/project/create-project.php" novalidate
                    enctype="multipart/form-data">
                    <?php include __DIR__ . '/project-details.html'; ?>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="<?= $listProjectPageLink ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-save me-1"></i>
                            Salve Project
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.html'; ?>