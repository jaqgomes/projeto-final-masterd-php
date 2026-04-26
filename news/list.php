<?php
require_once __DIR__ . '/../includes/header.html';
include('NewsService.php');

$newsService = new NewsService();
$newsList = $newsService->getAllNews();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="page-header mb-0">News table List</h2>
    <a href="/projeto-final/news/create.php" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add news</a>
</div>

<?php if (empty($newsList)): ?>

    <div class="card form-card">
        <div class="empty-state">
            <i class="bi bi-newspaper"></i>
            <h4>No news found</h4>
            <p>Get started by adding your first news</p>
            <a href="/news-crud/create.php" class="btn btn-primary">Add News</a>
        </div>
    </div>



<?php else: ?>
    <table class="table">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Titulo</th>
            <th scope="col">Conteúdo</th>
            <th scope="col">Data de Publicação</th>
            <th scope="col">Ações</th>
        </thead>

        <tbody>
            <?php foreach ($newsList as $news) { ?>
                <tr>
                    <td><?= $news['id'] ?></td>
                    <td><?= $news['titulo'] ?></td>
                    <td><?= $news['conteudo'] ?></td>
                    <td><?= substr($news['data_publicacao'] ?? '', 0, 10) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $news['id'] ?>" class="btn btn-outline-primary btn-sm flex-fill">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>

                        <a href="news-delete.php?id=<?= $news['id'] ?>" class="btn btn-outline-danger btn-sm flex-fill"
                            onclick="return confirm('Deseja excluir essa notícia?')">
                            <i class="bi bi-tras me-1"></i>Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.html'; ?>