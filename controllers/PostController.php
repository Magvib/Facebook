<?php

class PostController extends Controller
{
    public function index($params)
    {        
        if (!Auth::check()) {
            $this->redirect('/login');
        }

        // post id
        $id = $params['id'];

        // Get post
        $post = new Post($id);

        // Redirect to home if user doesn't exist
        if (!$post->id) {
            $this->redirect('/');
        }
        
        $this->render('PostView', [
            'post' => $post,
        ]);
    }
}
