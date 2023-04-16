<?php

class Post extends Model {
    public $title = '';
    public $content = '';
    public $author_id = '';

    public function getComments() {
        return Comment::getAllByField('post_id', $this->id, 'id', 'DESC');
    }

    public function getAuthor() {
        return User::getByField('id', $this->author_id);
    }

    public function getLikes() {
        return Likes::getAllByField('post_id', $this->id);
    }
}