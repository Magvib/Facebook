<?php

$postUser = new User($post->author_id);

?>

<div class="container text-center">
    <br />
    <h3>Post #<?= $post->id ?></h3>
    <div class="card">
        <div class="card-body">
            <h6><a href="/profile/<?= $postUser->username ?>"><?= $postUser->username ?></a></h6>
            <h5 class="card-title"><?= $post->title ?></h5>
            <p class="card-text"><?= $post->content ?></p>

            <form action="/post/<?= $post->id ?>/comment" method="POST">
                <div class="row">
                    <div class="col">
                        <input maxlength="50" class="form-control" type="text" name="content" placeholder="Comment" autocomplete="off" />
                    </div>
                    <div class="col">
                        <input class="btn btn-primary mb-3" type="submit" name="submit" value="Create" />
                    </div>
                </div>
            </form>
            
            <?php foreach($post->getComments() as $comment): ?>
                <?php
                    $commentUser = new User($comment->author_id);
                ?>
                <div class="alert alert-info" role="alert">
                    <a href="/profile/<?= $commentUser->username ?>"><?= $commentUser->username ?></a>: <?= $comment->content ?>
                </div>
            <?php endforeach; ?>

            <!-- Back button -->
            <a id="backBtn" href="#" class="btn btn-primary">Back</a>
            <script>
                document.getElementById('backBtn').addEventListener('click', function(e) {
                    e.preventDefault();
                    window.history.back();
                });
            </script>
        </div>
    </div>
</div>