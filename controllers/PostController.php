<?php

class PostController extends Controller
{
    public $auth = true;

    public function index($params)
    {
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

    public function deleteComment($params)
    {
        // post id
        $id = $params['id'];

        // Get post
        $post = new Post($id);

        // Redirect to home if post doesn't exist
        if (!$post->id) {
            $this->redirect('/');
        }

        // comment id
        $id_comment = $params['id_comment'];

        // Get comment
        $comment = new Comment($id_comment);

        // Redirect to home if comment doesn't exist
        if (!$comment->id) {
            $this->redirect('/');
        }

        // Check if user is author
        if ($comment->author_id != Auth::user()->id) {
            $this->redirect('/');
        }

        // Delete comment
        $comment->delete();

        // Redirect to home
        $this->redirect('/post/' . $id);
    }

    public function editComment($params)
    {
        // post id
        $id = $params['id'];

        // Get post
        $post = new Post($id);

        // Redirect to home if post doesn't exist
        if (!$post->id) {
            $this->redirect('/');
        }

        // comment id
        $id_comment = $params['id_comment'];

        // Get comment
        $comment = new Comment($id_comment);

        // Redirect to home if comment doesn't exist
        if (!$comment->id) {
            $this->redirect('/');
        }

        // Check if user is author
        if ($comment->author_id != Auth::user()->id) {
            $this->redirect('/');
        }

        // Check if form is submitted
        if (isset($params['submit'])) {
            // Check if content is set
            if (isset($params['content'])) {
                // Validate content
                if (strlen($params['content']) < 1 && strlen($params['content']) > 50) {
                    $this->redirect('/');
                }

                // Update comment
                $comment->content = $params['content'];
                $comment->save();

                // Redirect to home
                $this->redirect('/post/' . $id);
            }
        }

        $this->redirect('/');
    }

    public function like($params)
    {
        // post id
        $id = $params['id'];

        // Get post
        $post = new Post($id);

        // Redirect to home if post doesn't exist
        if (!$post->id) {
            $this->redirect('/');
        }

        // Check if user already liked post
        $like = Likes::getByFields([
            'post_id' => $post->id,
            'author_id' => Auth::user()->id
        ]);

        if ($like->id) {
            // Delete like
            $like->delete();
        } else {
            // Create like
            $like = new Likes();
            $like->post_id = $post->id;
            $like->author_id = Auth::user()->id;
            $like->save();
        }


        // Redirect to home
        $this->redirect('/post/' . $id);
    }

    public function delete($params)
    {
        // post id
        $id = $params['id'];

        // Get post
        $post = new Post($id);

        // Redirect to home if post doesn't exist
        if (!$post->id) {
            $this->redirect('/');
        }

        // Check if user is author
        if ($post->author_id != Auth::user()->id) {
            $this->redirect('/');
        }

        // Delete post
        $post->delete();

        // Redirect to home
        $this->redirect('/');
    }

    public function update($params)
    {
        // post id
        $id = $params['id'];

        // Get post
        $post = new Post($id);

        // Redirect to home if post doesn't exist
        if (!$post->id) {
            $this->redirect('/');
        }

        // Check if user is author
        if ($post->author_id != Auth::user()->id) {
            $this->redirect('/');
        }

        // Check if title is set and not empty
        if (isset($params['title']) && !empty($params['title'])) {
            // Check if title is valid
            if (strlen($params['title']) < 1 && strlen($params['title']) > 50) {
                $this->redirect('/');
            }

            // Update title
            $post->title = $params['title'];
        }

        // Check if content is set and not empty
        if (isset($params['content']) && !empty($params['content'])) {
            // Check if content is valid
            if (strlen($params['content']) < 1 && strlen($params['content']) > 1000) {
                $this->redirect('/');
            }

            // Update content
            $post->content = $params['content'];
        }

        // Save post
        try {
            $post->save();
            $this->redirect('/post/' . $post->id);
        } catch (\Throwable $th) {
            $this->redirect('/post/' . $post->id);
        }
    }
}
