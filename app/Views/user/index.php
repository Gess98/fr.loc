<div class="container">

    <?php foreach($users as $user): ?>
        <?= $user['name']; ?><br>
    <?php endforeach; ?>
    
    <br>
    <?= $pagination; ?>
</div>