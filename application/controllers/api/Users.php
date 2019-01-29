<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Users extends REST_Controller
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key


        $this->load->model('user_model');

    }

    /**
     * function GET that a user returns if they pass the ID in the ejm api/users/1 url or all users if an ID ejm api/users is not passed
     * @param null $id
     */
    public function index_get($id = NULL)
    {
        if ($id) {
            $users = $this->user_model->getUser($id);
        } else {
            $users = $this->user_model->getUsers();
        }

        if ($users) {
            $this->response($users, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'No users were found'
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }

    }

    /**
     * function POST that allows you to create a user
     */
    public function index_post()
    {
        if ($this->post()) {
            $user = [
                'email' => $this->post('email'),
                'password' => $this->post('password'),
                'name' => $this->post('name'),
                'image' => $this->post('image')
            ];

            $newUser = $this->user_model->saveUser($user);
            if ($newUser) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Created user'
                ], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'User not created',
                    'e' => $newUser
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code

            }
        }

    }

    /**
     * function PUT that allows you to update a user you must pass the ID in the url ejm api/users/1
     * @param $id
     */
    public function index_put($id)
    {
        if ($this->put()) {
            $user = [
                'email' => $this->put('email'),
                'password' => $this->put('password'),
                'name' => $this->put('name'),
                'image' => $this->put('image')
            ];

            $newUser = $this->user_model->saveUser($user, $id);
            if ($newUser) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Updated user'
                ], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'User not update'
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code

            }
        }
    }

    /**
     * function that allows you to delete a user you must pass the ID in the url ejm api/users/1
     * @param $id
     */
    public function index_delete($id)
    {
        $deleteUser = $this->user_model->delete($id);
        if ($deleteUser) {
            $this->set_response([
                'status' => TRUE,
                'message' => 'User delete'
            ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'User not delete'
            ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code

        }
    }

    /**
     * function POST that allows an image to be uploaded to the user, the ID must be passed in the url ejm api/users/upload/1
     * @param $id
     */
    function upload_post($id)
    {
        $uploaddir = 'uploads/';
        $file_name = underscore($_FILES['file']['name']);
        $uploadfile = $uploaddir . $file_name;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
            $dataDB['status'] = 'success';
            $dataDB['id'] = $id;
            $dataDB['url'] = $this->config->item('base_url') . $uploaddir . $file_name;
            $dataDB['filename'] = $file_name;

            $user = $this->user_model->getUser($id);


            $userUpdate = [
                'email' => $user->email,
                'name' => $user->name,
                //'password' => $user->password,
                'image' => $dataDB['url']
            ];

            $newUser = $this->user_model->saveUser($userUpdate, $id);

            if ($newUser) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Updated user'
                ], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'User not update'
                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code

            }

        }else {
            $this->response([
                'status' => FALSE,
                'message' => 'User not update'
            ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code

        }

    }
}