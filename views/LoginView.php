<?php

?>

<div class="pt-5">
    <div class="container">
        <?php if (isset($error) && $error) : ?>
            <div class="alert alert-danger" role="alert"><?= $error ?></div>
        <?php endif; ?>
        <h1 class="text-center">Login</h1>
        <form action="/login" method="post">
            <label for="username" class="mt-3">Username</label>
            <input type="text" name="username" placeholder="Username" class="form-control" autocomplete="off" />
            <label for="password" class="mt-3">Password</label>
            <input type="password" name="password" placeholder="Password" class="form-control" autocomplete="off" />
            <!-- recaptcha -->
            <label for="recaptcha" class="mt-3">Recaptcha</label>
            <input type="text" name="recaptcha" placeholder="Recaptcha" class="form-control" autocomplete="off" />
            <img src="/recaptcha" class="rounded mt-3" />
            <br>
            <input type="submit" name="submit" value="Login" class="btn btn-primary mt-3" />
        </form>
    </div>
</div>