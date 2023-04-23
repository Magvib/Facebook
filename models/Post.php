<?php

class Post extends Model
{
    public $title = '';
    public $content = '';
    public $author_id = '';
    public $date_add = '';
    public $date_upd = '';

    public function getComments()
    {
        return Comment::getAllByField('post_id', $this->id, 'id', 'DESC');
    }

    public function getAuthor()
    {
        return User::getByField('id', $this->author_id);
    }

    public function getLikes()
    {
        return Likes::getAllByField('post_id', $this->id);
    }

    public static function getFriendsPosts(array $friendsIds, int $page, int $limit, $orderBy = null, $order = null): array
    {
        $data = Db::getInstance()->table(get_called_class());

        foreach ($friendsIds as $id) {
            $data->orWhere('author_id', $id);
        }

        // If $friendsIds is empty, return empty array
        if (!$friendsIds) {
            return [];
        }

        if ($orderBy && $order) {
            $data = $data->orderBy($orderBy, $order);
        }

        $data = $data->paginate($page, $limit);

        if (!$data) {
            return new static();
        }

        $listOfData = [];

        foreach ($data as $key => $value) {
            $listOfData[] = new static($value->id);
        }

        return $listOfData;
    }
}
