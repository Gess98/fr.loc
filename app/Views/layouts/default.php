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

    <nav class="navbar navbar-expand-lg bg-dark mb-3" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?=base_href(); ?>"><?php _e("tpl_logo"); ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?= cache()->get('menu'); ?>

                <?php $request_uri = uri_without_lang();?>

                <ul class="navbar-nav">

                    <?php if(check_auth()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Hello, <?= get_user()['name']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_href("/logout");?>">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= app()->get('lang')['title']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php foreach (LANGS as $k => $v): ?>
                                <?php if(app()->get('lang')['code'] == $k) continue; ?>
                                <?php if ($v['base'] == 1): ?>
                                    <li><a class="dropdown-item" href="<?= base_url("{$request_uri}");?>"><?= $v['title'];?></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?= base_url("/{$k}{$request_uri}");?>"><?= $v['title'];?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php 
        // dump(\PHPFramework\Auth::isAuth());
        // dump(\PHPFramework\Auth::user());
        // dump(get_user()['name']);
    ?>

    <?php get_alerts(); ?>
    <!-- вывод вида -->
    <?= $content;?>

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