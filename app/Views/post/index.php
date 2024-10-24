<div class="container">

    <ul>
        <?php foreach($posts as $post): ?>
            <li><a href="<?=base_href("/post/{$post['slug']}"); ?>"><?= $post['title']; ?><br></a></li>
        <?php endforeach; ?>
    </ul>

</div>