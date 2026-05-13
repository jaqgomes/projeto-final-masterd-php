<?php
require_once __DIR__ . '/security/SessionService.php';

// Flash messages via session
session_start();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

require_once __DIR__ . '/includes/header.php';
?>

<?php if ($flash): ?>
    <div class="alert alert-<?= $flash['type'] ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?> me-2"></i>
        <?= htmlspecialchars($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<section class="hero">
    <div class="row align-items-center gy-4">
        <div class="col-lg-7">
            <span class="badge bg-warning text-dark mb-3">Bem-vindo ao sistema</span>
            <h1 class="display-5 fw-bold mb-3">
                <?= SessionService::isLoggedIn() ? 'Bem-vindo de volta à Jaqueline News' : 'Bem-vindo à Jaqueline News' ?>
            </h1>
            <p class="lead mb-4">Acompanhe as últimas notícias, organize projetos e gerencie conteúdo com elegância e
                segurança.</p>
            <div class="d-flex flex-column flex-sm-row gap-2">
                <a class="btn btn-light btn-lg btn-hero" href="/projeto-final/news/list-news.php">
                    <i class="bi bi-newspaper me-1"></i> Ver notícias
                </a>
                <a class="btn btn-outline-light btn-lg btn-hero" href="/projeto-final/project/list-project.php">
                    <i class="bi bi-kanban me-1"></i> Ver projetos
                </a>
            </div>
            <?php if (!SessionService::isLoggedIn()): ?>
                <p class="mt-3 mb-0 text-white-75">Já tem conta? <a class="text-white text-decoration-underline"
                        href="/projeto-final/security/login.php">Faça login</a> ou <a
                        class="text-white text-decoration-underline" href="/projeto-final/security/register.php">registre-se
                        agora</a>.</p>
            <?php endif; ?>
        </div>
        <div class="col-lg-5">
            <div class="hero-card p-4 h-100">
                <h5 class="mb-3">Seu espaço de gestão de conteúdo</h5>
                <p class="mb-4">Tenha um painel simples e moderno para publicar notícias, monitorar projetos e manter
                    sua atividade sempre atualizada.</p>
                <ul class="list-unstyled mb-0">
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-warning me-2"></i>Design claro e responsivo
                    </li>
                    <li class="mb-3"><i class="bi bi-check-circle-fill text-warning me-2"></i>Conteúdo fácil de acessar
                    </li>
                    <li><i class="bi bi-check-circle-fill text-warning me-2"></i>Login e cadastro seguros</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section-intro">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Notícias em destaque</h5>
                    <p class="card-text">Confira as notícias publicadas com uma visualização organizada e fácil de
                        navegar.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Projetos inteligentes</h5>
                    <p class="card-text">Gerencie seus projetos com rapidez e mantenha o foco nas tarefas mais
                        importantes.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card h-100">
                <div class="card-body">
                    <h5 class="card-title">Fácil de usar</h5>
                    <p class="card-text">Uma página inicial elegante que apresenta suas funcionalidades com clareza.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.html'; ?>