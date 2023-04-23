<?php

class User extends Model
{
    private const MD5SALT = '8znZy5Xe#oQiv#Io**vZxND519v8nwvp^DRVdJ8olzYkyr*Eq$UNjMSz^oYf2C&EFba8hEUOFmBDTHFKpnXmx^yZGhGWSNF6eKG';

    public $username = '';
    public $email = '';
    public $password = '';
    public $bio = '';

    public function getPosts()
    {
        return Post::getAllByField('author_id', $this->id);
    }

    public function getComments()
    {
        return Comment::getAllByField('author_id', $this->id);
    }

    public function getLikes()
    {
        return Likes::getAllByField('user_id', $this->id);
    }

    public function setPassword($password)
    {
        $this->password = md5(self::MD5SALT . $password);
    }
}
