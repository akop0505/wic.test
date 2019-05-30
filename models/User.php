<?php
namespace  models;

use core\Model;

class User extends Model {

    private $table = "users";

    private $id;
    private $firstName;
    private $lastName;
    private $username;
    private $email;
    private $password;


    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if($name === "password"){
            throw new \Exception("impossible action to get password");
        }
        return $this->$name;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->$name = htmlspecialchars(strip_tags($value));
    }

    /**
     * @param $data
     */
    private function setAttributes($data){
        $this->id = $data['id'];
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->username = $data['username'];
        $this->email = $data['email'];
    }

    /**
     * @return array
     */
    public function getAttributes(){
        return [
          "id"=>(integer)$this->id,
          "firstName"=>$this->firstName,
          "lastName"=>$this->lastName,
          "username"=>$this->username,
          "email"=>$this->email
        ];
    }

    /**
     * @return bool
     */
    public function save(){
        $query = "INSERT INTO ".$this->table
            ." SET first_name  = :first_name,"
            ." last_name = :last_name,"
            ." email = :email,"
            ." username = :username,"
            ." password = :password";
        $params = [
            ":first_name"=>$this->firstName,
            ":last_name"=>$this->lastName,
            ":username"=>$this->username,
            ":email"=>$this->email,
            ":password"=> password_hash($this->password, PASSWORD_BCRYPT)
        ];

        $id = $this->db->createQuery($query,$params);

        if($id){
            $user = $this->getById($id);
            $this->setAttributes($user);
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @return array
     */
    public function getAll(){
        $query = "select id, first_name as firstName, last_name as lastName, username, email from ".$this->table;
        return  $this->db->query($query);
    }


    /**
     * @param $id
     * @return array
     */
    public function getById($id){
        $query = "select id, first_name as firstName, last_name as lastName, username, email from ".$this->table. " where id=:id limit 1";
        $result = $this->db->query($query,['id'=>$id]);
        if(count($result)){
            return $result[0];
        }
        else{
            return [];
        }
    }

    /**
     * @return bool
     */
    public function login(){
        //$hash_password = password_hash($this->password, PASSWORD_BCRYPT);
        $query = "select id, first_name as firstName, last_name as lastName, username, email , password from ".$this->table
        ." where username = :username limit 1";
        $result = $this->db->query($query,[':username'=>$this->username]);
        if(count($result)){
//            dd(password_verify($this->password,$result[0]['password']));
            if(password_verify($this->password,$result[0]['password'])){
                $this->setAttributes($result[0]);
                return true;
            }

            return false;
        }
        else{
            return false;
        }
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function createToken(){
        $token = bin2hex(random_bytes(64));
        $query = "INSERT INTO user_auth"
            ." SET user_id  = :user_id,"
            ." token = :token,"
            ." active = :active;";
        $params = [
            ":user_id"=>$this->id,
            ":token"=>$token,
            ":active"=>1
        ];
        if($this->db->createQuery($query,$params)){
           return $token;
        };
    }

    /**
     * @param $token
     * @return array
     */
    public function getUserByToken($token){
        $query = "select users.id as id, first_name as firstName, last_name as lastName, username, email from users "
            ."INNER JOIN user_auth on users.id = user_auth.user_id where user_auth.token = :token && active = 1";

        $result = $this->db->query($query,['token'=>$token]);
        if(count($result)){
            return $result[0];
        }
        else{
            return [];
        }
    }
}