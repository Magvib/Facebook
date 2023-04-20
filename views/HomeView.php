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
        ?>

        <br />
        <div class="card">
            <div class="card-body">
                <h4><span class="badge bg-secondary"><a href="/profile/<?= $postUser->username ?>"><?= $postUser->username ?></a></span><span class="badge bg-secondary ms-1">Likes: <?= $likes ?></span><span class="badge bg-secondary ms-1">Comments: <?= $comments ?></span></h4>
                <h5 class="card-title"><?= $post->title ?></h5>
                <p class="card-text"><?= $post->content ?></p>

                <!-- Link to post -->
                <a href="/post/<?= $post->id ?>" class="btn btn-primary">View</a>
            </div>
        </div>
    <?php endforeach; ?>
    <br>
</div>