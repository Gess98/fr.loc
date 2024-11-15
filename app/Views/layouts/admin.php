<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Базовый url адрес нужен для того, чтобы дописывать его к относительным ссылкам -->
    <base href="<?= base_url('/'); ?>">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= get_csrf_meta(); ?>
    <title>PHPFramework :: <?=$title ?? '';?></title>
    <link rel="icon" href="<?=base_url("/favicon.png"); ?>">
    <link rel="stylesheet" href="<?=base_url("/assets/bootstrap/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?=base_url("/assets/iziModal/css/iziModal.min.css"); ?>">

    <!-- Подключение стилей -->
    <?php if(!empty($styles)):?>
        <?php foreach($styles as $style): ?>
            <link rel="stylesheet" href="<?=$style; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Подключение скриптов -->
    <?php if(!empty($header_scripts)):?>
        <?php foreach($header_scripts as $header_script): ?>
            <script src="<?= $header_script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>
    
<div class="container-fluid" style="padding-left: 0; padding-right: 0">
    <div class="d-flex flex-row">
        <div class="d-flex flex-column sticky-top flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh;">
            <a href="/" class="ps-4 d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">Logo</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item ps-3">
                    <a href="#" class="nav-link text-white" aria-current="page">Home</a>
                </li>
                <li class="nav-item ps-3">
                    <a href="#" class="nav-link text-white">Users</a>
                </li>
                <li class="nav-item ps-3">
                    <a href="<?= base_href("/admin/posts"); ?>" class="nav-link text-white">Posts</a>
                </li class="nav-item ps-3">
                <li class="nav-item ps-3">
                    <a href="#" class="nav-link text-white">Statistics</a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <strong>Username</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="<?=base_href('/admin/new-post')?>">New post</a></li>
                    <li><a class="dropdown-item" href="#">New user</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_href('/logout'); ?>">Sign out</a></li>
                </ul>
            </div>
        </div>

            <?php get_alerts(); ?>
            <!-- вывод вида -->
            <?= $content;?>
    </div>
</div>



    <script src="<?=base_url("/assets/js/jquery-3.7.1.min.js"); ?>"></script>
    <script src="<?=base_url("/assets/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
    <script src="<?=base_url("/assets/iziModal/js/iziModal.min.js"); ?>"></script>


    <!-- Подключение скриптов -->
    <?php if(!empty($footer_scripts)):?>
        <?php foreach($footer_scripts as $footer_script): ?>
            <script src="<?= $footer_script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <script src="<?=base_url("/assets/js/main.js"); ?>"></script>

    <!-- инициализация модального окна для iziModal -->
     <div class="iziModal-alert-success"></div>
     <div class="iziModal-alert-error"></div>

</body>
</html>