<?php
require_once __DIR__ . '/../includes/header.html';
include('ProjectService.php');

$pageTitle = 'Gerenciador de Projetos - Sistema Web';

session_start();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$projectService = new ProjectService();
$projectList = $projectService->getAllProjects();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="page-header mb-0">Projets Manager</h2>
    <a href="/projeto-final/project/create-project.php" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Add Project</a>
</div>

<?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-<?= $flash['type'] === 'sucess' ? 'check-circle' : 'exclamation-triangule' ?> me-2"></i>
        <?= htmlspecialchars($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dimiss="alert"></button>
    </div>

<?php endif; ?>

<?php if (empty($projectList)): ?>
    <div class="card form-card">
        <div class="empty-state">
            <i class="bi bi-plus-lg me-1"></i>
            <h4>Nenhuma projeto encontrado.</h4>
            <p>Comece adicionando seu primeiro projeto. </p>
            <a href="/projeto-final/project/create-project.php" class="btn btn-primary">Adicionar projetos</a>
        </div>

    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome do Projeto</th>
                    <th scope="col">Tecnologia</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>


            <tbody>
                <?php foreach ($projectList as $project) { ?>
                    <tr>
                        <td><?= $project['id'] ?></td>
                        <td><?= $project['nome_projeto'] ?></td>
                        <td><?= $project['tecnologia'] ?></td>

                        <td>
                            <a href="edit-project.php?id=<?= $project['id'] ?>" class="btn btn-outline-primary btn-sm flex-fill">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm flex-fill" data-bs-toggle="modal"
                                data-bs-target="#deleteModal" 
                                data-id="<?= $project['id'] ?>"
                                data-name="<?= htmlspecialchars($project['nome_projeto']) ?>"
                                data-action="/projeto-final/project/delete-project.php">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php include __DIR__ . '/../includes/modal.html'; ?>

    <?php endif; ?>

    <?php require_once __DIR__ . '/../includes/footer.html'; ?>