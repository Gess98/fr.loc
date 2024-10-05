<div class="container">

    <h1><?=$title ?? '';?></h1>


    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="<?= base_url('/register'); ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="password">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input name="confirmPassword" type="password" class="form-control" id="confirmPassword" placeholder="confirm Password">
                </div>
                <button type="submit" class="btn btn-warning">Register</button>
            </form>
        </div>
    </div>
</div>