<?php

?>

<div class="container text-center">
    <br />
    <h3>Profile</h3>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $profileUser->username ?></h5>
            <p class="card-text"><?= $profileUser->bio ?></p>
        </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">Total posts: <?= count($posts) ?></li>
                <li class="list-group-item">Total comments: <?= $commentCount ?></li>
                <li class="list-group-item">Total friends: <?= count($friends) ?></li>
            </ul>
        <div class="card-body">
            <?php if ($isProfileUser) : ?>
                <div x-data="{ editProfile: false }">
                    <!-- Button to edit profile -->
                    <button x-show="!editProfile" @click="editProfile = !editProfile" class="btn btn-primary">Edit Profile</button>
                    <div x-show="editProfile">
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
                            <!-- Cancel button -->
                            <button @click.prevent="editProfile = !editProfile;" class="btn btn-danger">Cancel</button>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            <?php else : ?>
                <?php if (!$isFriend && !$hasRequest && !$hasSentRequest) : ?>
                    <!-- Show a button to add friend -->
                    <form action="/profile/<?= $profileUser->username ?>/add" method="POST">
                        <button type="submit" class="btn btn-primary">Add Friend</button>
                    </form>
                <?php elseif ($isFriend || $hasSentRequest) : ?>
                    <!-- Button to remove friend / friend request -->
                    <form action="/profile/<?= $profileUser->username ?>/remove" method="POST">
                        <button type="submit" class="btn btn-danger"><?= $isFriend ? 'Remove Friend' : 'Remove friend request' ?></button>
                    </form>
                <?php elseif ($hasRequest) : ?>
                    <!-- Button to accept friend request -->
                    <form action="/profile/<?= $profileUser->username ?>/add" method="POST">
                        <button type="submit" class="btn btn-success">Accept Friend Request</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <br />
    <h3>User Posts</h3>
    <ul class="list-group">
        <?php foreach ($posts as $post) : ?>
            <li class="list-group-item">
                <a href="/post/<?= $post->id ?>"><?= $post->title ?></a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>