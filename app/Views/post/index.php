<div class="container">
    <div class="row">
        <div class="col-9">
            <?php foreach($posts as $post): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?= $post['title']; ?></h5>
                        <p class="card-text"><?= $post['description']; ?></p>
                        <a href="<?=base_href("/post/{$post['slug']}"); ?>" class="btn btn-dark">Read</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-3">
            <h2>Recent posts</h2>
            <ul class="list-group">
                <?php foreach($recent_posts as $recent_post):?>
                    <li class="list-group-item">
                        <a class="nav-link" href="<?=base_href("/post/{$recent_post['slug']}"); ?>"><?= $recent_post['title']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div> 
</div>