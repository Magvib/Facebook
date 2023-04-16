<?php

use Firehed\U2F\Server;

class HomeController extends Controller
{
    public function index($params)
    {        
        if (!Auth::check()) {
            $this->redirect('/login');
        }
        
        $this->render('HomeView', [
            'title' => 'Home',
        ]);
    }
    
    public function login($params)
    {
        // Check if user is logged in
        if (Auth::check()) {
            $this->redirect('/');
        }

        // Check if form is submitted
        if (isset($params['submit'])) {
            // Check if username and password are set
            if (isset($params['username']) && isset($params['password'])) {
                // Attempt to login
                if (Auth::login($params['username'], $params['password'])) {
                    $this->redirect('/');
                } else {
                    $this->render('LoginView', [
                        'error' => 'Invalid username or password'
                    ]);
                }
            }
        }

        $this->render('LoginView');
    }

    public function logout($params)
    {
        // Logout user
        Auth::logout();

        // Redirect to home
        $this->redirect('/');
    }

    public function register($params)
    {
        if (Auth::check()) {
            $this->redirect('/');
        }
        
        if (isset($params['submit'])) {
            if (isset($params['username']) && isset($params['email']) && isset($params['password'])) {
                if (Auth::register($params['username'], $params['email'], $params['password'])) {
                    $this->redirect('/');
                } else {
                    $this->render('RegisterView', [
                        'error' => 'Username or email already exists'
                    ]);
                }
            }
        }

        $this->render('RegisterView');
    }
}