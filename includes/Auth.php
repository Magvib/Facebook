<?php

class Auth
{
    private static $md5Salt = '8znZy5Xe#oQiv#Io**vZxND519v8nwvp^DRVdJ8olzYkyr*Eq$UNjMSz^oYf2C&EFba8hEUOFmBDTHFKpnXmx^yZGhGWSNF6eKG';
    
    public static function check(): bool
    {
        // Check if user is logged in
        return isset($_SESSION['user']);
    }

    public static function user(): bool|MareiObj
    {
        // Check if user is logged in
        if (!self::check()) {
            return false;
        }

        $user = Db::getInstance()->select('username')->table('User')->where('username', '=', $_SESSION['user'])->get()->first();

        if (!$user) {
            return false;
        }
        
        return $user;
    }

    public static function login(string $username, string $password): bool
    {
        $encryptedPassword = md5(self::$md5Salt . $password);

        $user = Db::getInstance()->select('username, password')->table('User')->where('username', '=', $username)->get()->first();

        // Return false if user is not found
        if (!$user) {
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
        $user = Db::getInstance()->select('username')->table('User')->where('username', '=', $username)->get()->first();

        if ($user) {
            return false;
        }

        // Check if email is already taken
        $user = Db::getInstance()->select('email')->table('User')->where('email', '=', $email)->get()->first();

        if ($user) {
            return false;
        }

        // Encrypt password
        $encryptedPassword = md5(self::$md5Salt . $password);

        // Insert user into database
        Db::getInstance()->insert('User', [
            'username' => $username,
            'email' => $email,
            'password' => $encryptedPassword
        ]);

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
