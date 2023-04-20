<?php

// Hide Deprecated
error_reporting(E_ALL ^ E_DEPRECATED);

// Disable error reporting if not in development
if ($_SERVER['SERVER_NAME'] != 'localhost' && $_SERVER['SERVER_NAME'] != '127.0.0.1') {
    error_reporting(0);
}

// Load autoloader.php
require 'Autoloader.php';

// Start session
session_start();

$router = new AltoRouter();

$router->addRoutes([
    /* ---------------------------------- Feed ---------------------------------- */
    ['GET', '/', 'HomeController#index'],

    /* --------------------------------- Profile -------------------------------- */
    ['GET', '/profile/[*:username]', 'ProfileController#index'],
    ['GET', '/profile', 'ProfileController#myProfile'],
    ['POST', '/profile', 'ProfileController#updateProfile'],

    /* ---------------------------------- Post ---------------------------------- */
    ['GET', '/post/[i:id]', 'PostController#index'],
    ['POST', '/post/[i:id]', 'PostController#update'],
    ['POST', '/post/[i:id]/delete', 'PostController#delete'],
    ['POST', '/post', 'PostController#create'],
    ['POST', '/post/[i:id]/comment', 'PostController#createComment'],
    ['POST', '/post/[i:id]/like', 'PostController#like'],
    ['POST', '/post/[i:id]/comment/[i:id_comment]/like', 'PostController#likeComment'],
    ['POST', '/post/[i:id]/comment/[i:id_comment]/delete', 'PostController#deleteComment'],

    /* ---------------------------------- Auth ---------------------------------- */
    ['GET|POST', '/login', 'HomeController#login'],
    ['GET', '/logout', 'HomeController#logout'],
    ['GET|POST', '/register', 'HomeController#register'],
]);

$match = $router->match();

Controller::match($match);
