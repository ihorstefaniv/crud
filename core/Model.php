<?php

namespace core;
class Model
{
    /**
     * Create
     */

    public $tableName = 'users';

    private $db;

    function __construct()
    {
        $this->db = new \mysqli(DB_HOST, DB_USERNAME,DB_PASSWORD ,DB_NAME );

        // Check connection
        if ( $this->db -> connect_errno) {
          echo "Failed to connect to MySQL: " .  $this->db -> connect_error;
          exit();
        }
    }


    public function create($data)
    {

        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $status = $data['status'];
        $role = $data['role'];

        $query = "INSERT INTO $this->tableName (first_name, last_name , status, role)
        VALUES ('$first_name', '$last_name', $status, $role);";
        $this->db->query($query);

       
        if($this->db->error){
            return ['status' => false, 'message' => $this->db->error];
        }

        return ['status'=> true, 'id' =>$this->db->insert_id];

    }

    public function getOne($id)
    {
        $query = "SELECT * FROM $this->tableName WHERE id = $id";
        $result = $this->db-> query($query);
        return $result -> fetch_all(MYSQLI_ASSOC);

    }

    public function getAll()
    {

        $query = "SELECT * FROM $this->tableName";
        $result = $this->db-> query($query);
        return $result -> fetch_all(MYSQLI_ASSOC); 
    }

    public function update($id, $data)
    {
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $status = $data['status'];
        $role = $data['role'];

        $query = "UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_name', `status` = '$status', `role` = '$role' WHERE `users`.`id` = $id;";
        $this->db->query($query);
       
       if($this->db->error){
            return ['status' => false, 'message' => $this->db->error];
        }

        return ['status'=> true, 'id' =>$id];
      
    }

    public function delete($id)
    {
        $query = "DELETE FROM $this->tableName WHERE id = $id";
        $this->db->query($query);

       if($this->db->error){
            return $this->db->error;
        }

        return true;    
    }

    public function setActive($id) {        
        $status = 1;
        $query = "UPDATE `users` SET  `status` = '$status' WHERE `users`.`id` = id;";
        $this->db->query($query);
    }

    public function setUnActive($ids) {
        $status = 2;
        $query = "UPDATE `users` SET  `status` = '$status' WHERE `users`.`id` = id;";
        $this->db->query($query);
    }
}