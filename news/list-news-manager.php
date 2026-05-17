<?php
require_once __DIR__ . '/../security/SessionService.php';

include('NewsService.php');

$pageTitle = 'Gerenciador de Noticias — Sistema Web';

// Flash messages via session
session_start();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
SessionService::isRequireAdmin();

$newsService = new NewsService();
$newsList = $newsService->getAllNews();

$createNewsPageLink = "create-news.php";
$deleteNewsPageLink = "delete-news.php";

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="page-header mb-0">News Manager</h2>
    <a href="<?= $createNewsPageLink ?>" class="btn btn-dark"><i class="bi bi-plus-lg me-1"></i>Add news</a>
</div>

<?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
        <?= htmlspecialchars($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (empty($newsList)): ?>

    <div class="card form-card">
        <div class="empty-state">
            <i class="bi bi-newspaper"></i>
            <h4>Nenhuma notícia encontrada. </h4>
            <p>Comece adicionando sua primeira notícia.</p>
            <a href="<?= $createNewsPageLink ?>" class="btn btn-dark">Add News</a>
        </div>
    </div>

<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titulo</th>
                <th scope="col">Conteúdo</th>
                <th scope="col">Data de Publicação</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($newsList as $news) { ?>
                <tr>
                    <td><?= $news['id'] ?></td>
                    <td><?= $news['titulo'] ?></td>
                    <td><?= $news['conteudo'] ?></td>
                    <td><?= substr($news['data_publicacao'] ?? '', 0, 10) ?></td>
                    <td>
                        <a href="edit-news.php?id=<?= $news['id'] ?>" class="btn btn-outline-dark btn-sm flex-fill">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm flex-fill" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-id="<?= $news['id'] ?>"
                            data-name="<?= htmlspecialchars($news['titulo']) ?>"
                            data-action="<?= $deleteNewsPageLink ?>">
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