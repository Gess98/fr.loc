<div class="container">

    <h1><?=$title ?? '';?></h1>


    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="<?= base_url('/register'); ?>" method="post" class="ajax-form">

                <?= get_csrf_field(); ?>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control <?= get_validation_class('name'); ?>" id="name" placeholder="name" value="<?= old('name'); ?>">
                    <?= get_errors('name'); ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control <?= get_validation_class('email'); ?>" id="email" placeholder="name@example.com" value="<?= old('email'); ?>">
                    <?= get_errors('email'); ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control <?= get_validation_class('password'); ?>" id="password" placeholder="password">
                    <?= get_errors('password'); ?>
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input name="confirmPassword" type="password" class="form-control <?= get_validation_class('confirmPassword'); ?>" id="confirmPassword" placeholder="confirm Password">
                    <?= get_errors('confirmPassword'); ?>
                </div>
                <button type="submit" class="btn btn-warning">Register</button>
            </form>

            <?php
                // Удаление данных из массива SESSION для того чтобы ошибки показывались 1 раз
                session()->remove('form_data');
                session()->remove('form_errors');
            ?>

        </div>
    </div>
</div>