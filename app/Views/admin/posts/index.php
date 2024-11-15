<div class="container text-center">
    <div class="row">
        <div class="col">
            <?php foreach($posts as $post): ?>
                <div class="card mb-3">
                    <div class="d-flex justify-content-between card-body">
                        <h5 class="card-title"><?= $post['title']; ?></h5>
                        <div>
                            <a href="<?=base_href("/admin/post/{$post['slug']}"); ?>" class="btn btn-dark">Deleat</a>
                            <a href="<?=base_href("/post/{$post['slug']}"); ?>" class="btn btn-dark">Update</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>