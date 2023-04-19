<?php

$user = Auth::user();

$posts = $profileUser->getPosts();
$commentCount = Comment::getAllByField('author_id', $profileUser->id);
$commentCount = count($commentCount);

// Check if user is equals to profile user
$isProfileUser = $user->id == $profileUser->id;

?>

<div class="container text-center">
    <br />
    <h3>Profile</h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $profileUser->username ?></h5>
            <p class="card-text"><?= $profileUser->bio ?></p>
            <p class="card-text">Total posts: <?= count($posts) ?></p>
            <p class="card-text">Total comments: <?= $commentCount ?></p>
            
            <?php if($isProfileUser): ?>
                <form action="/profile" method="POST">
                    <!-- Username field -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?= $user->username ?>">
                    </div>
                    <br>
                    <!-- Email field -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= $user->email ?>">
                    </div>
                    <br>
                    <!-- Bio field -->
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea class="form-control" name="bio" id="bio" rows="3"><?= $user->bio ?></textarea>
                    </div>
                    <br>
                    <!-- Password field -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <br>
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            <?php endif; ?>
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