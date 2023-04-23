<?php

class HomeController extends Controller
{
    public $auth = false;

    public function index($params)
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }

        // TODO Top feed
        // TODO Friends feed

        // Global feed
        $posts = Post::getAll(1, 10, 'id', 'DESC');

        $this->render('HomeView', [
            'title' => 'Home',
            'user' => Auth::user(),
            'posts' => $posts
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
            // Check if recaptcha is set and is valid
            if (isset($params['recaptcha']) && $params['recaptcha'] != $_SESSION['captcha']) {
                $this->render('LoginView', [
                    'error' => 'Invalid recaptcha'
                ]);
            }

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
        $this->redirect('/login');
    }

    public function register($params)
    {
        if (Auth::check()) {
            $this->redirect('/');
        }

        if (isset($params['submit'])) {
            // Check if recaptcha is set and is valid
            if (isset($params['recaptcha']) && $params['recaptcha'] != $_SESSION['captcha']) {
                $this->render('RegisterView', [
                    'error' => 'Invalid recaptcha'
                ]);
            }

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

    public function recaptcha($params)
    {
        $captcha = '';
        $height = 50;
        $width = 130;
        $length = 6;
        
        $chars = 'bcdfghjkmnpqrstvwxyz23456789';
        $font = './monofont.ttf';

        $dot_amount = 50;
        $line_amount = 25;
        $captcha_text_color = "0x142864";
        $captcha_noise_color = "0x142864";

        $count = 0;
        while ($count < $length) {
            $captcha .= substr(
                $chars,
                mt_rand(0, strlen($chars) - 1),
                1
            );
            $count++;
        }

        $font_size = $height * 0.65;
        $captcha_image = @imagecreate(
            $width,
            $height
        );

        // Background color
        imagecolorallocate(
            $captcha_image,
            255,
            255,
            255
        );

        $array_text_color = $this->hextorgb($captcha_text_color);
        $captcha_text_color = imagecolorallocate(
            $captcha_image,
            $array_text_color['red'],
            $array_text_color['green'],
            $array_text_color['blue']
        );

        $array_noise_color = $this->hextorgb($captcha_noise_color);
        $image_noise_color = imagecolorallocate(
            $captcha_image,
            $array_noise_color['red'],
            $array_noise_color['green'],
            $array_noise_color['blue']
        );

        // Random dots
        for ($count = 0; $count < $dot_amount; $count++) {
            imagefilledellipse(
                $captcha_image,
                mt_rand(0, $width),
                mt_rand(0, $height),
                2,
                3,
                $image_noise_color
            );
        }

        // Random lines
        for ($count = 0; $count < $line_amount; $count++) {
            imageline(
                $captcha_image,
                mt_rand(0, $width),
                mt_rand(0, $height),
                mt_rand(0, $width),
                mt_rand(0, $height),
                $image_noise_color
            );
        }
        
        $text_box = imagettfbbox(
            $font_size,
            0,
            $font,
            $captcha
        );

        imagettftext(
            $captcha_image,
            $font_size,
            0,
            ($width - $text_box[4]) / 2,
            ($height - $text_box[5]) / 2,
            $captcha_text_color,
            $font,
            $captcha
        );


        header('Content-Type: image/jpeg');
        imagejpeg($captcha_image);
        imagedestroy($captcha_image);

        $_SESSION['captcha'] = $captcha;
    }

    function hextorgb($hexstring)
    {
        $integar = hexdec($hexstring);
        return array(
            "red" => 0xFF & ($integar >> 0x10),
            "green" => 0xFF & ($integar >> 0x8),
            "blue" => 0xFF & $integar
        );
    }
}
