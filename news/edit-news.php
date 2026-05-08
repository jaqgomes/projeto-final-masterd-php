<?php
include('NewsService.php');

session_start();

$newsService = new NewsService();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$news = $newsService->getNewsById($id);

if (!$news) {
    http_response_code(404);
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'News not found.'];
    header('Location: /projeto-final/news/list-news-manager.php');
    exit;
}

//metodo usado para validar e convertar data para exibir na tela
if (!empty($news['data_publicacao'])) {
    $dateObj = new DateTime($news['data_publicacao']);
    $date = $dateObj->format('Y-m-d');
}

$pageTitle = 'Edit News — Web System';
$errors = [];
$input = $news;
$input['date'] = $date ?? ''; //se tiver valor em $date usa ele, se não tiver usa ''

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input['titulo'] = trim($_POST['titulo'] ?? '');
    $input['conteudo'] = trim($_POST['conteudo'] ?? '');
    $input['date'] = trim($_POST['date'] ?? '');

    if ($input['titulo'] === '') {
        $errors['titulo'] = 'Titulo is required.';
    }

    if ($input['conteudo'] === '') {
        $errors['conteudo'] = 'Conteudo is required.';
    }

    if ($input['date'] === '') {
        $input['date'] = null;
    }

    if (!empty($_POST['remover_imagem']) && !empty($news['imagem'])) {

        $caminho = __DIR__ . '/uploads/' . $news['imagem'];

        // Apaga o ficheiro físico
        if (file_exists($caminho)) {
            unlink($caminho);
        }

        // Define imagem como NULL no banco
        $input['imagem'] = null;

    } elseif (!empty($_FILES['imagem']['name'])) {

        $file = $_FILES['imagem'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['imagem'] = 'Erro ao enviar a imagem.';

        } else {
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($file['type'], $allowed)) {
                $errors['imagem'] = 'A imagem deve ser JPEG, PNG ou WEBP.';
            }
        }

        $input['imagem'] = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $destino = __DIR__ . '/uploads/' . $input['imagem'];

        move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
    } else {
        $input['imagem'] = $news['imagem'];
    }

    if (empty($errors)) {

        $newsService->updateNews(
            $id,
            $input['titulo'],
            $input['conteudo'],
            $input['imagem'],
            $input['date']
        );

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Noticia alterada com sucesso!'];
        header('Location: /projeto-final/news/list-news-manager.php');
        exit;
    }
}

require_once __DIR__ . '/../includes/header.html';
?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <h2 class="page-header">Edit News</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Please fix the errors below.
            </div>

        <?php endif; ?>

        <div class="card form-card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>News Details
            </div>
            <div class="card-body p-4">
                <form method="POST" action="/projeto-final/news/edit-news.php?id=<?= $id ?>" novalidate
                    enctype="multipart/form-data">

                    <?php include __DIR__ . '/news-details.html'; ?>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="/projeto-final/news/list-news-manager.php" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
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