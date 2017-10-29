<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function create($data)
    {
        $this->db->insert('posts', $data);
    }

    public function update($post_id, $data)
    {
        $this->db->where('post_id', $post_id);
        $this->db->update('posts', $data);
    }

    public function get_post($post_id)
    {
        $result = $this->db->get_where('posts', array('post_id' => $post_id))->first_row();
        if($result)
        {
            $author = $this->ion_auth->user($result->author)->row();
            $result->author = $author;
        }
        return $result;
    }

    public function get_posts()
    {
        $this->db->order_by('publish_date', 'DESC');
        $this->db->order_by('post_id', 'DESC');
        $results = $this->db->get('posts')->result();
        foreach ($results as $key => $result) {
            $author = $this->ion_auth->user($result->author)->row();
            $results[$key]->author = $author;
        }
        return $results;
    }
}