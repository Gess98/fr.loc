<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= get_csrf_meta(); ?>
    <title>PHPFramework :: <?=$title ?? '';?></title>
    <link rel="icon" href="<?=base_url("/favicon.png"); ?>">
    <link rel="stylesheet" href="<?=base_url("/assets/bootstrap/css/bootstrap.min.css"); ?>">
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-dark mb-3" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php // app()->get('menu') ?>
                <?= cache()->get('menu'); ?>
            </div>
        </div>
    </nav>

    <?php get_alerts(); ?>
    <!-- вывод вида -->
    <?= $content;?>

    <script src="<?=base_url("/assets/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
</body>
</html>