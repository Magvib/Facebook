<?php

class Friend extends Model
{
    public $user_id = '';
    public $friend_id = '';
    public $accepted = '';
    public $date_add = '';
    public $date_upd = '';

    public function getUser()
    {
        return User::getByField('id', $this->user_id);
    }

    public function getFriend()
    {
        return User::getByField('id', $this->friend_id);
    }

    public static function getFriends($user_id, $accepted = 1, $friendsModel = true)
    {
        $friends = Db::getInstance()
            ->table('Friend')
            ->where([['user_id', $user_id], ['accepted', $accepted]])
            ->orWhere([['friend_id', $user_id]])
            ->where([['accepted', $accepted]])
            ->get()
            ->toArray();

        // Check if empty
        if (!$friends) {
            return [];
        }

        $friends = array_map(function ($friend) use ($user_id, $friendsModel) {
            // Check if user_id is equal to user_id
            if ($friendsModel) {
                return new Friend($friend['id']);
            }
            
            if ($friend['user_id'] == $user_id) {
                return new User($friend['friend_id']);
            } else {
                return new User($friend['user_id']);
            }
        }, $friends);

        return $friends;
    }
}
