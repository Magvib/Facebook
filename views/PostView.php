<?php

$postUser = new User($post->author_id);
$user = Auth::user();

$likes = count($post->getLikes());
$comments = count($post->getComments());

// Check if user is author of post
$isAuthor = $user->id == $postUser->id;

?>

<div class="container text-center">
    <br />
    <h3>Post #<?= $post->id ?> <span class="badge bg-secondary"><a href="/profile/<?= $postUser->username ?>"><?= $postUser->username ?></a></span><span class="badge bg-secondary ms-2">Likes: <?= $likes ?></span><span class="badge bg-secondary ms-2">Comments: <?= $comments ?></span></h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $post->title ?></h5>
            <p class="card-text"><?= $post->content ?></p>

            <div class="row">
                <div class="col-<?= ($isAuthor ? '6' : '12') ?>">
                    <!-- Back button -->
                    <a style="width: 100%" id="backBtn" href="#" class="btn btn-primary">Back</a>
                    <script>
                        document.getElementById('backBtn').addEventListener('click', function(e) {
                            e.preventDefault();
                            window.history.back();
                        });
                    </script>
                </div>
                <div class="col-6">
                    <!-- Delete button -->
                    <?php if ($isAuthor) : ?>
                        <form action="/post/<?= $post->id ?>/delete" method="POST">
                            <input style="width: 100%" class="btn btn-danger" type="submit" name="submit" value="Delete" />
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-8">
                    <form action="/post/<?= $post->id ?>/comment" method="POST">
                        <input maxlength="50" class="form-control" type="text" name="content" placeholder="Comment" autocomplete="off" />
                </div>
                <div class="col-2">
                    <input style="width: 100%" class="btn btn-primary mb-3" type="submit" name="submit" value="Create" />
                    </form>
                </div>
                <div class="col-2">
                    <form action="/post/<?= $post->id ?>/like" method="POST">
                        <input style="width: 100%" class="btn btn-primary mb-3" type="submit" name="submit" value="Like" />
                    </form>
                </div>
            </div>

            <?php foreach ($post->getComments() as $comment) : ?>
                <?php
                $commentUser = new User($comment->author_id);
                ?>
                <div class="alert alert-dark" role="alert">
                    <a href="/profile/<?= $commentUser->username ?>"><?= $commentUser->username ?></a>: <?= $comment->content ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>