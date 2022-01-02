<?php
// Posts Controller Class
class Posts extends Controller
{
    public function __construct()
    {
        $this->postModel = $this->model('Post');
    }

    public function index()
    {
        $posts = $this->postModel->findAllPosts();
        $data = [
            'title' => 'Posts',
            'posts' => $posts
        ];
        $this->view('posts/index', $data);
    }

    // create post
    public function create()
    {
        if(!isLoggedIn())
        {
            header('Location:'. URLROOT .'posts');
        }
        $data = [
            'title' => 'Create Post',
            'post_title' => '',
            'body' => '',
            'bodyError' => '',
            'titleError' => ''
        ];

        // check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // sanitize form data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => 'Create Post',
                'user_id' => $_SESSION['user_id'],
                'post_title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'bodyError' => '',
                'titleError' => ''
            ];

            if(empty($data['post_title']))
            {
                $data['titleError'] = 'Post Title can not be empty';
            }

            if(empty($data['body']))
            {
                $data['bodyError'] = 'Post Body can not be empty';
            }

            if(empty($data['titleError']) && empty($data['bodyError']))
            {
                if($this->postModel->addPost($data))
                {
                    header('Location:' .URLROOT . 'posts');
                }
                else
                {
                    die('something went wrong, please try again');
                }
            }
            else
            {
                $this->view('posts/create', $data);
            }
        }
        $this->view('posts/create',$data);
    }

    // update post
    public function update($id)
    {
        $post = $this->postModel->findPostById($id);
        if(!isLoggedIn())
        {
            header('Location:' .URLROOT . 'posts');
        }
        elseif($post->user_id != $_SESSION['user_id'])
        {
            header('Location:' .URLROOT . 'posts');
        }


        $data = [
            'title' => 'Update post',
            'post' => $post,
            'post_title' => '',
            'body' => '',
            'titleError' => '',
            'bodyError' => ''
        ];

        // check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // sanitize form data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'title' => 'Update Post',
                'post' => $post,
                'id' => $id,
                'user_id' => $_SESSION['user_id'],
                'post_title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'bodyError' => '',
                'titleError' => ''
            ];

            if(empty($data['post_title']))
            {
                $data['titleError'] = 'Post Title can not be empty';
            }

            if(empty($data['body']))
            {
                $data['bodyError'] = 'Post Body can not be empty';
            }

            if($data['post_title'] == $this->postModel->findPostById($id)->title)
            {
                $data['titleError'] = 'Atleast Change the Title';
            }

            if($data['body'] == $this->postModel->findPostById($id)->body)
            {
                $data['bodyError'] = 'Atleast Change the body';
            }

            if(empty($data['titleError']) && empty($data['bodyError']))
            {
                if($this->postModel->updatePost($data))
                {
                    header('Location:' .URLROOT . 'posts');
                }
                else
                {
                    die('something went wrong, please try again');
                }
            }
            else
            {
                $this->view('posts/update', $data);
            }
        }

        $this->view('posts/update', $data);
    }

    public function delete($id)
    {
        $post = $this->postModel->findPostById($id);
        if(!isLoggedIn())
        {
            header('Location:' .URLROOT . 'posts');
        }
        elseif($post->user_id != $_SESSION['user_id'])
        {
            header('Location:' .URLROOT . 'posts');
        }


        $data = [
            'title' => 'Delete post',
            'post' => $post,
            'post_title' => '',
            'body' => '',
            'titleError' => '',
            'bodyError' => ''
        ];

        // check if method is post
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if($this->postModel->deletePost($id))
            {
                header('Location:' .URLROOT . 'posts');
            }
            else
            {
                die("something Went wrong");
            }
        }
    }
}