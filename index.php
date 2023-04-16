<?php

// Hide Deprecated
error_reporting(E_ALL ^ E_DEPRECATED);

// Load autoloader.php
require 'Autoloader.php';

// Start session
session_start();

$router = new AltoRouter();

$router->addRoutes([
    ['GET', '/', 'HomeController#index'],
    ['GET', '/profile/[*:username]', 'ProfileController#index'],
    ['GET', '/profile', 'ProfileController#myProfile'],
    ['GET|POST', '/login', 'HomeController#login'],
    ['GET', '/logout', 'HomeController#logout'],
    ['GET|POST', '/register', 'HomeController#register'],
]);

$match = $router->match();

Controller::match($match);
