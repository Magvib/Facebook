<?php

class ProfileController extends Controller
{
    public $auth = true;

    public function index($params)
    {
        // Profile id
        $username = $params['username'];

        // Get user
        $user = User::getByField('username', $username);

        // Redirect to home if user doesn't exist
        if (!$user->id) {
            $this->redirect('/');
        }
        
        $this->render('ProfileView', [
            'title' => $user->username . '- Profile',
            'profileUser' => $user,
        ]);
    }

    public function myProfile()
    {
        $user = Auth::user();

        // TODO Make it possible to change username email and password

        $this->render('ProfileView', [
            'title' => $user->username . '- Profile',
            'profileUser' => $user,
        ]);
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

    public function sendFriendRequest($params)
    {
        
    }
}
