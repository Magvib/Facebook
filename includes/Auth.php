<?php

class Auth
{
    private static $md5Salt = '8znZy5Xe#oQiv#Io**vZxND519v8nwvp^DRVdJ8olzYkyr*Eq$UNjMSz^oYf2C&EFba8hEUOFmBDTHFKpnXmx^yZGhGWSNF6eKG';

    public static function check(): bool
    {
        // Check if user is logged in
        return isset($_SESSION['user']);
    }

    public static function user(): bool|User
    {
        // Check if user is logged in
        if (!self::check()) {
            return false;
        }

        $user = User::getByField('username', $_SESSION['user']);

        if (!$user->id) {
            return false;
        }

        return $user;
    }

    public static function login(string $username, string $password): bool
    {
        $encryptedPassword = md5(self::$md5Salt . $password);

        $user = User::getByField('username', $username);

        // Return false if user is not found
        if (!$user->id) {
            return false;
        }

        // Check if password is correct
        if ($user->password != $encryptedPassword) {
            return false;
        }

        // Set session
        $_SESSION['user'] = $user->username;

        return true;
    }

    public static function register(string $username, string $email, string $password): bool
    {
        // Check if user is logged in
        if (self::check()) {
            return false;
        }

        // Check if username and email is valid
        if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Check if username is already taken
        $user = User::getByField('username', $username);

        if ($user->id) {
            return false;
        }

        // Check if email is already taken
        $user = User::getByField('email', $email);

        if ($user->id) {
            return false;
        }

        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->save();

        // Set session
        $_SESSION['user'] = $username;

        return true;
    }

    public static function logout(): bool
    {
        // Unset session
        unset($_SESSION['user']);

        return true;
    }
}
