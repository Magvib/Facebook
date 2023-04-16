<?php

?>

<?php if(isset($error) && $error): ?>
    <p><?php echo $error; ?></p>
<?php endif; ?>

<div style="margin-top: 10px;margin-left: 10px;">
    <form action="/login" method="post">
        <input type="text" name="username" placeholder="Username" autocomplete="off" />
        <input type="password" name="password" placeholder="Password" autocomplete="off" />
        <input type="submit" name="submit" value="Login" />
    </form>
</div>