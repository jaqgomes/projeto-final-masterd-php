<?php
require_once __DIR__ . '/../security/SessionService.php';

include 'NewsService.php';

$newsService = new NewsService();
$newsList = $newsService->getAllNews();

session_start();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

require_once __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="page-header mb-0">Noticias</h2>
    <?php if (SessionService::isLoggedIn()): ?>
    <a href="/projeto-final/news/list-news-manager.php" class="btn btn-dark">
        <i class="bi bi-plus-lg me-1"></i>Gerenciar Noticias</a>
    <?php endif; ?>
</div>

<?php if (empty($newsList)): ?>
    <h1>Nenhuma Noticia</h1>
<?php else: ?>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($newsList as $news) { ?>
            <div class="col">
                <div class="card h-100">
                    <?php if (!empty($news['imagem'])): ?>
                        <img src="/projeto-final/news/uploads/<?= $news['imagem'] ?>" class="card-img-top">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $news['titulo'] ?></h5>
                        <p class="card-text"><?= $news['conteudo'] ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/footer.html'; ?>