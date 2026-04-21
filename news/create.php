<?php
include('NewsService.php');

$newsService = new NewsService();

session_start();

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
    }

    if (empty($errors)) {
        $input['imagem'] = uniqid() . '-' . basename($_FILES['imagem']['name']);
        $destino = __DIR__ . '/uploads/' . $input['imagem'];

        move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

        $newsService->createNews(
            $input['titulo'],
            $input['conteudo'],
            $input['imagem'],
            $input['date']
        );

        $_SESSION['flash'] = ['type' => 'sucess', 'message' => 'News added successfully!'];
        header('Location: /projeto-final/news/list.php');
        exit;
    }
}

require_once __DIR__ . '/../includes/header.html';
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
                <form method="POST" action="/projeto-final/news/create.php" novalidate enctype="multipart/form-data">


                    <div class="row g-3">

                        <!--Titulo-->
                        <div class="col-md-4">
                            <label for="titulo" class="form-titulo">Título<span class="text-danger">*</span></label>
                            <input type="text" id="titulo" name="titulo"
                                class="form-control <?= isset($errors['titulo']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($input['titulo']) ?>" maxlength="100">
                            <?php if (isset($errors['titulo'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['titulo'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!--Imagem-->
                        <div class="col-md-8">
                            <label class="imagem-label" for="imagem" name="imagem">Imagem</label>
                            <input type="file" id="imagem" name="imagem" class="form-control" >
                        </div>

                        <!--Conteudo-->
                        <div class="col-md-12">
                            <label for="conteudo" class="conteudo-label">Conteudo <span
                                    class="text-danger">*</span></label>
                            <textarea id="conteudo" name="conteudo"
                                class="form-control <?= isset($errors['conteudo']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($input['conteudo']) ?>" style="height: 150px"></textarea>
                            <?php if (isset($errors['conteudo'])): ?>
                                <div class="invalid-feedback">
                                    <?= $errors['conteudo'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!--Data de publicacao-->
                        <div class="col-md-6">
                            <label for="date" class="data-label">Data de publicação</label>
                            <input type="date" id="date" name="date" class="form-control">
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="/projeto-final/news/list.php" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-1"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
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