<?php

class Post extends Model {
    public $title = '';
    public $content = '';
    public $author_id = '';
    public $date_add = '';
    public $date_upd = '';

    public function getComments() {
        return Comment::getAllByField('post_id', $this->id);
    }
}