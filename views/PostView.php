<?php

$postUser = new User($post->author_id);
$user = Auth::user();

$likes = count($post->getLikes());
$comments = count($post->getComments());

// Check if user is author of post
$isAuthor = $user->id == $postUser->id;

$date = date('d/m/Y H:i', strtotime($post->date_add));

// Check if already liked
$alreadyLiked = Likes::getByFields([
    'post_id' => $post->id,
    'author_id' => $user->id
]);

?>

<div class="container text-center">
    <br />
    <div class="card">
        <h5 class="card-header">Post #<?= $post->id ?></h5>
        <div class="card-body">
            <h5 class="card-title"><?= $post->title ?></h5>
            <p class="card-text"><?= $post->content ?></p>

            <div class="row" x-data="{ editPost: false }">
                <div class="col-<?= ($isAuthor ? '4' : '12') ?>">
                    <!-- Back button -->
                    <a style="width: 100%" id="backBtn" href="#" class="btn btn-primary">Back</a>
                    <script>
                        document.getElementById('backBtn').addEventListener('click', function(e) {
                            e.preventDefault();
                            window.history.back();
                        });
                    </script>
                </div>
                <div class="col-4">
                    <!-- Delete button -->
                    <?php if ($isAuthor) : ?>
                        <form action="/post/<?= $post->id ?>/delete" method="POST">
                            <input style="width: 100%" class="btn btn-danger" type="submit" name="submit" value="Delete" />
                        </form>
                    <?php endif; ?>
                </div>
                <div class="col-4">
                    <!-- Edit button -->
                    <?php if ($isAuthor) : ?>
                        <!-- Button to editPost = true -->
                        <button x-show="!editPost" @click="editPost = !editPost" style="width: 100%" class="btn btn-primary">Edit</button>
                        <!-- Cancel button -->
                        <button x-show="editPost" @click="editPost = !editPost" style="width: 100%" class="btn btn-warning">Cancel</button>
                    <?php endif; ?>
                </div>
                <div class="col-12">
                    <!-- Edit form -->
                    <?php if ($isAuthor) : ?>
                        <br>
                        <form x-show="editPost" action="/post/<?= $post->id ?>" method="POST">
                            <label for="title">Title</label>
                            <input maxlength="50" class="form-control" type="text" name="title" placeholder="Title" value="<?= $post->title ?>" autocomplete="off" />
                            <br>
                            <label for="content">Content</label>
                            <input maxlength="255" class="form-control" type="text" name="content" placeholder="Content" value="<?= $post->content ?>" autocomplete="off" />
                            <br>
                            <input style="width: 100%" class="btn btn-primary" type="submit" name="submit" value="Update" />
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
                        <input style="width: 100%" class="btn btn-<?= $alreadyLiked->id ? 'warning' : 'primary' ?> mb-3" type="submit" name="submit" value="<?= $alreadyLiked->id ? 'Unlike' : 'Like' ?>" />
                    </form>
                </div>
            </div>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">User: <a href="/profile/<?= $postUser->username ?>"><?= $postUser->username ?></a></li>
            <li class="list-group-item">Likes: <?= $likes ?></li>
            <li class="list-group-item">Comments: <?= $comments ?></li>
        </ul>
        <div class="card-body">
            <?php foreach ($post->getComments() as $comment) : ?>
                <?php
                $commentUser = new User($comment->author_id);
                $isCommentAuthor = $user->id == $commentUser->id;
                ?>
                <div class="alert alert-dark row" role="alert">
                    <div class="col-<?= ($isCommentAuthor ? '6' : '12') ?>" style="    margin-top: auto;margin-bottom: auto;">
                        <a href="/profile/<?= $commentUser->username ?>"><?= $commentUser->username ?></a>: <?= $comment->content ?>
                    </div>
                    <?php if ($isCommentAuthor) : ?>
                        <!-- Delete button -->
                        <div class="col-6">
                            <form action="/post/<?= $post->id ?>/comment/<?= $comment->id ?>/delete" method="POST">
                                <input style="width: 100%" class="btn btn-danger" type="submit" name="submit" value="Delete" />
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="card-footer text-body-secondary" style="margin-top: -15px;">
            <?= $date ?>
        </div>
    </div>
</div>