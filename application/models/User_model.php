<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * function that allows to obtain all the users of the database
     *
     * @return mixed
     */
    public function getUsers()
    {
        $this->db->select('id, name, email, image');
        $this->db->from('users');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * function that allows to obtain a user of the database if ID
     *
     * @param $id
     * @return mixed
     */
    public function getUser($id)
    {
        $this->db->select('id, name, email, image');
        $this->db->from('users');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * function that allows to save or update a user in the database
     *
     * @param $user
     * @param null $id
     * @return bool
     */
    public function saveUser($user, $id = null)
    {
        try {
            $data = array(
                'email' => $user['email'],
                'password' => crypt($user['password']),
                'name' => $user['name'],
                'image' => $user['image']
            );
            if ($id) {
                $this->db->where('id', $id);
                return $this->db->update('users', $data);
            } else {
                return $this->db->insert('users', $data);
            }
        } catch (Exception $e) {
            return FALSE;
        }
    }

    /**
     * function that allows to eliminate a user in the database
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

}