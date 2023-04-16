<?php

class ProfileController extends Controller
{
    public function index($params)
    {        
        if (!Auth::check()) {
            $this->redirect('/login');
        }

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
        if (!Auth::check()) {
            $this->redirect('/login');
        }

        $user = Auth::user();

        // TODO Make it possible to change username email and password

        $this->render('ProfileView', [
            'title' => $user->username . '- Profile',
            'profileUser' => $user,
        ]);
    }
}
