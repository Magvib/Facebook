<?php

class Comment extends Model {
    public $content = '';
    public $post_id = '';
    public $author_id = '';
    public $date_add = '';
    public $date_upd = '';

    public function getAuthor() {
        return User::getByField('id', $this->author_id);
    }

    public function getPost() {
        return Post::getByField('id', $this->post_id);
    }

    public function getLikes() {
        return Likes::getAllByField('comment_id', $this->id);
    }
}