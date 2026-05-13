<?php
require_once __DIR__ . '/../security/SessionService.php';


include('NewsService.php');

$newsService = new NewsService();

session_start();
SessionService::isRequireLogin();

$listNewsPageLink = "/projeto-final/news/list-news-manager.php";

$pageTitle = 'Add News — Web System';
$errors = [];
$input = ['titulo' => '', 'conteudo' => '', 'date' => '', 'imagem' => ''];

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

    if (!empty($_FILES['imagem']['name'])) {

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
        $input['imagem'] = null;
    }

    if (empty($errors)) {

        $newsService->createNews(
            $input['titulo'],
            $input['conteudo'],
            $input['imagem'],
            $input['date']
        );

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'News added successfully!'];
        header("Location: $listNewsPageLink");
        exit;
    }
}

require_once __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <h2 class="page-header">Add News</h2>

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
                <form method="POST" action="/projeto-final/news/create-news.php" novalidate enctype="multipart/form-data">


                    <?php include __DIR__ . '/news-details.html'; ?>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="<?= $listNewsPageLink ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg me-1"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-save me-1"></i>
                            Salve News
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.html'; ?>