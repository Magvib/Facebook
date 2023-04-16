<?php

$user = Auth::user();

$posts = $profileUser->getPosts();
$commentCount = Comment::getAllByField('author_id', $profileUser->id);
$commentCount = count($commentCount);

?>

<div class="container text-center">
    <br />
    <h3>Profile</h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $profileUser->username ?></h5>
            <p class="card-text">Bio.</p>
            <p class="card-text">Total posts: <?= count($posts) ?></p>
            <p class="card-text">Total comments: <?= $commentCount ?></p>
        </div>
    </div>

    <br />
    <h3>User Posts</h3>
    <ul class="list-group">
        <?php foreach($posts as $post): ?>
            <li class="list-group-item">
                <a href="/post/<?= $post->id ?>"><?= $post->title ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>