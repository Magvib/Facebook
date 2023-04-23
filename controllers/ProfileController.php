<?php

class ProfileController extends Controller
{
    public $auth = true;

    public function index($params)
    {
        // Profile id
        $username = $params['username'];

        // Get user
        $profileUser = User::getByField('username', $username);

        // Redirect to home if user doesn't exist
        if (!$profileUser->id) {
            $this->redirect('/');
        }

        $user = Auth::user();

        $posts = $profileUser->getPosts();
        $friends = Friend::getFriends($profileUser->id, 1, false);
        $request = Friend::getFriends($profileUser->id, 0, true);
        $commentCount = count(Comment::getAllByField('author_id', $profileUser->id));

        // Check if user is equals to profile user
        $isProfileUser = $user->id == $profileUser->id;

        // Check if user is friend
        $isFriend = !!array_filter($friends, function ($friend) use ($user) {
            return $friend->id == $user->id;
        });

        // Check if logged in user has send a friend request
        $hasSentRequest = !!array_filter($request, function ($friend) use ($user) {
            return $friend->user_id == $user->id;
        });

        // Check if profile user has send a friend request
        $hasRequest = !!array_filter($request, function ($friend) use ($user) {
            return $friend->friend_id == $user->id;
        });
        
        $this->render('ProfileView', [
            'profileUser' => $profileUser,
            'user' => $user,
            'posts' => $posts,
            'friends' => $friends,
            'commentCount' => $commentCount,
            'isProfileUser' => $isProfileUser,
            'isFriend' => $isFriend,
            'hasRequest' => $hasRequest,
            'hasSentRequest' => $hasSentRequest,
        ]);
    }

    public function myProfile()
    {
        $user = Auth::user();
        $this->index(['username' => $user->username]);
    }

    public function updateProfile()
    {
        $user = Auth::user();

        // Check if username isset
        if (isset($_POST['username']) && !empty($_POST['username']) && preg_match('/^[a-zA-Z0-9]{3,20}$/', $_POST['username'])) {
            $user->username = $_POST['username'];
        }

        // Check if email isset
        if (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $user->email = $_POST['email'];
        }

        // Check if password isset
        if (isset($_POST['password']) && !empty($_POST['password'])) {
            $user->setPassword($_POST['password']);
        }

        // Check if bio isset
        if (isset($_POST['bio']) && !empty($_POST['bio']) && preg_match('/^[a-zA-Z0-9\s]{3,100}$/', $_POST['bio'])) {
            $user->bio = $_POST['bio'];
        }

        try {
            $user->save();
            $this->redirect('/profile');
        } catch (\Throwable $th) {
            $this->redirect('/profile');
        }
    }

    public function addFriend($params)
    {
        $user = Auth::user();

        // Profile id
        $username = $params['username'];

        // Get user
        $profileUser = User::getByField('username', $username);

        // Redirect to home if user doesn't exist
        if (!$profileUser->id) {
            $this->redirect('/');
        }

        // Check if user is equals to profile user
        $isProfileUser = $user->id == $profileUser->id;

        // Redirect to profile if user is profile user
        if ($isProfileUser) {
            $this->redirect('/profile/' . $profileUser->username);
        }

        $isFriend = !!array_filter(Friend::getFriends($profileUser->id, 1, false), function ($friend) use ($user) {
            return $friend->id == $user->id;
        });
        
        // Redirect to profile if user is already friend
        if ($isFriend) {
            $this->redirect('/profile/' . $profileUser->username);
        }

        // Check if friend request already exists
        $hasRequest = array_filter(Friend::getFriends($profileUser->id, 0), function ($friend) use ($user) {
            return $friend->friend_id == $user->id || $friend->user_id == $user->id;
        });
        
        // Accept if friend request already exists
        if (count($hasRequest) >= 1) {
            $friend = $hasRequest[0];
            $friend->accepted = 1;

            try {
                $friend->save();
                $this->redirect('/profile/' . $profileUser->username);
            } catch (\Throwable $th) {
                $this->redirect('/profile/' . $profileUser->username);
            }
        }

        // Create friend
        $friend = new Friend();
        $friend->user_id = $user->id;
        $friend->friend_id = $profileUser->id;
        $friend->accepted = 0;

        try {
            $friend->save();
            $this->redirect('/profile/' . $profileUser->username);
        } catch (\Throwable $th) {
            $this->redirect('/profile/' . $profileUser->username);
        }
    }

    public function removeFriend($params)
    {
        $user = Auth::user();

        // Profile id
        $username = $params['username'];

        // Get user
        $profileUser = User::getByField('username', $username);

        // Redirect to home if user doesn't exist
        if (!$profileUser->id) {
            $this->redirect('/');
        }

        // Check if user is equals to profile user
        $isProfileUser = $user->id == $profileUser->id;

        // Redirect to profile if user is profile user
        if ($isProfileUser) {
            $this->redirect('/profile/' . $profileUser->username);
        }

        $isFriend = array_filter(Friend::getFriends($profileUser->id, 1), function ($friend) use ($user) {
            return $friend->user_id == $user->id || $friend->friend_id == $user->id;
        });

        $isRequest = array_filter(Friend::getFriends($profileUser->id, 0), function ($friend) use ($user) {
            return $friend->user_id == $user->id || $friend->friend_id == $user->id;
        });

        if (count($isFriend) >= 1) {
            $friend = $isFriend[0];

            try {
                $friend->delete();
                $this->redirect('/profile/' . $profileUser->username);
            } catch (\Throwable $th) {
                $this->redirect('/profile/' . $profileUser->username);
            }
        }

        if (count($isRequest) >= 1) {
            $friend = $isRequest[0];

            try {
                $friend->delete();
                $this->redirect('/profile/' . $profileUser->username);
            } catch (\Throwable $th) {
                $this->redirect('/profile/' . $profileUser->username);
            }
        }
        
        $this->redirect('/profile/' . $profileUser->username);
    }
}
