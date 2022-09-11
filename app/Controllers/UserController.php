<?php
namespace app\Controllers;

class UserController{

    private $collection;

    public function __construct()
    {
        $this->collection = json_decode(file_get_contents("../data/users.json"), true);
    }

    /**
     * Lists all the users in the app
     * 
     * @return Array
     */
    public function index(){
        return [
            'status' => 'success',
            'data' => $this->collection
        ];
    }

    /**
     * Lists a user given it's id
     * 
     * @param int $id
     * 
     * @return Array
     */
    public function getById($id){
        
        $key = array_search($id, array_column($this->collection, 'id'));
        return $key !== false ? [
            'status' => 'success',
            'data' => $this->collection[$key]
        ] : [
            'status' => 'error',
            'message' => 'User not found'
        ];
    }

    /**
     * stores a new user
     * 
     * @param Array $data
     * 
     * @return Array
     */
    public function store($data){
        $new_user = [
            'id' => count($this->collection) + 1,
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email']
        ];

        $data = array_push($this->collection, $new_user);
        file_put_contents('../data/users.json', json_encode($this->collection));
        return [
            'status' => 'success',
            'message' => 'User added'
        ];
    }

    /**
     * updates a new user
     * 
     * @param int $id
     * @param Array $data
     * 
     * @return Array
     */
    public function update($id, $data){
        $key = array_search($id, array_column($this->collection, 'id'));
        if($key !== false){

            array_key_exists('name', $data) ? ($this->collection[$key]['name'] = $data['name']) : null;
            array_key_exists('lastname', $data) ? ($this->collection[$key]['lastname'] = $data['lastname']) : null;
            array_key_exists('email', $data) ? ($this->collection[$key]['email'] = $data['email']) : null;

            file_put_contents('../data/users.json', json_encode($this->collection));
            return [
                'status' => 'success',
                'message' => 'User updated'
            ];

        } else {
            return [
                'status' => 'error',
                'message' => 'User not found'
            ];
        }
    }

    /**
     * deletes a user given it's id
     * 
     * @param int $id
     * 
     * @return Array
     */
    public function destroy($id){
        $key = array_search($id, array_column($this->collection, 'id'));
        if($key !== false){
            unset($this->collection[$key]);
            file_put_contents('../data/users.json', json_encode($this->collection));
            return [
                'status' => 'success',
                'message' => 'User deleted'
            ];

        } else {
            return [
                'status' => 'error',
                'message' => 'User not found'
            ];
        }
    }

}