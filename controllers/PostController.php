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

    public function create($params)
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }

        // Check if form is submitted
        if (isset($params['submit'])) {
            // Check if content is set
            if (isset($params['content']) && isset($params['title'])) {
                // Validate title
                if (strlen($params['title']) < 1 && strlen($params['title']) > 50) {
                    $this->redirect('/');
                }

                // Validate content
                if (strlen($params['content']) < 1 && strlen($params['content']) > 1000) {
                    $this->redirect('/');
                }
                
                // Create post
                $post = new Post();
                $post->title = $params['title'];
                $post->content = $params['content'];
                $post->author_id = Auth::user()->id;
                $post->save();

                // Redirect to home
                $this->redirect('/');
            }
        }

        $this->redirect('/');
    }

    public function createComment($params)
    {
        if (!Auth::check()) {
            $this->redirect('/login');
        }

        // Check if form is submitted
        if (isset($params['submit'])) {
            // Check if content is set
            if (isset($params['content'])) {
                // Validate content
                if (strlen($params['content']) < 1 && strlen($params['content']) > 50) {
                    $this->redirect('/');
                }
                
                // Create comment
                $comment = new Comment();
                $comment->content = $params['content'];
                $comment->author_id = Auth::user()->id;
                $comment->post_id = $params['id'];
                $comment->save();

                // Redirect to home
                $this->redirect('/post/' . $params['id']);
            }
        }

        $this->redirect('/');
    }
}
