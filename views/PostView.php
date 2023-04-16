<?php

?>

<div class="container text-center">
    <br />
    <h3>Post #<?= $post->id ?></h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $post->title ?></h5>
            <p class="card-text"><?= $post->content ?></p>

            <!-- Back button -->
            <a href="/" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>