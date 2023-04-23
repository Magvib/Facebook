<?php

?>

<div class="container text-center">
    <br />
    <h3>Home</h3>

    <div x-data="{ createPost: false }">
        <!-- Button to create post -->
        <button x-show="!createPost" @click="createPost = !createPost" class="btn btn-primary">Create Post</button>
        <div x-show="createPost" class="card">
            <div class="card-body">
                <h5 class="card-title">Create post</h5>

                <!-- Form to create post with /post -->
                <form action="/post" method="POST">
                    <input maxlength="50" class="form-control" type="text" name="title" placeholder="Title" autocomplete="off" />
                    <br />
                    <textarea maxlength="1000" class="form-control" name="content" placeholder="Content" autocomplete="off"></textarea>
                    <br />
                    <!-- Cancel button and prevent default -->
                    <button @click.prevent="createPost = !createPost" class="btn btn-danger">Cancel</button>
                    <input class="btn btn-primary" type="submit" name="submit" value="Create" />
                </form>
            </div>
        </div>
    </div>

    <br />
    <h3>Global feed</h3>

    <?php foreach ($posts as $post) : ?>
        <?php
        $postUser = new User($post->author_id);
        $likes = count($post->getLikes());
        $comments = count($post->getComments());

        // Convert date fx 2 days ago
        $date = date('d/m/Y H:i', strtotime($post->date_add));
        ?>

        <br />
        <div class="card">
            <h5 class="card-header">Post #<?= $post->id ?></h5>
            <div class="card-body">
                <h5 class="card-title"><?= $post->title ?></h5>
                <p class="card-text"><?= $post->content ?></p>

                <!-- Link to post -->
                <a href="/post/<?= $post->id ?>" class="btn btn-primary">View</a>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">User: <a href="/profile/<?= $postUser->username ?>"><?= $postUser->username ?></a></li>
                <li class="list-group-item">Likes: <?= $likes ?></li>
                <li class="list-group-item">Comments: <?= $comments ?></li>
            </ul>
            <div class="card-footer text-body-secondary">
                <?= $date ?>
            </div>
        </div>
    <?php endforeach; ?>
    <br>
</div>