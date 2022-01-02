<?php
// Post Model class
class Post
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // find all posts
    public function findAllPosts()
    {
        $this->db->query('SELECT * FROM posts ORDER BY created_at ASC');

        $results = $this->db->resultSet();
        return $results;
    }

    // add post
    public function addPost($data)
    {
        $this->db->query('INSERT INTO posts (user_id, title, body) VALUES(:user_id , :title, :body)');

        // bind params
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['post_title']);
        $this->db->bind(':body', $data['body']);


        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // find post by id
    public function findPostById($id)
    {
        $this->db->query('SELECT * FROM posts WHERE post_id = :id');

        // bind id
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }

    // update post

    public function updatePost($data)
    {
        $this->db->query('UPDATE posts SET title = :title, body = :body WHERE post_id = :id');

        // bind id
        $this->db->bind(':id',$data['id']);
        $this->db->bind(':title',$data['post_title']);
        $this->db->bind(':body',$data['body']);

        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // delete post
    public function deletePost($id)
    {
        $this->db->query('DELETE FROM posts WHERE post_id = :id');

        // bind id
        $this->db->bind(':id',$id);

        // execute query
        if($this->db->execute())
        {
            return true;
        }
        else
        {
            return false;
        }

    }
}