<?php
namespace database;

use PDO;

class DB{

    protected $db;

    public function __construct()
    {
        $config = require "config/db.php";
        try{
            $this->db =  new PDO("mysql:host=".$config['host'].";dbname=".$config['name'],$config['user'],$config["password"]);
        }
        catch (\PDOException $exception){
            echo  $exception->getMessage();
            die;
        }
    }

    /**
     * @param $sql
     * @param array $params
     * @return bool
     */
    private function runSql($sql,$params = []){
        $stmt = $this->db->prepare($sql);
        if( count($params) >= 1 ){
            foreach ($params as $k=>$v){
                $stmt->bindParam(":".$k,$v);
            }
        }
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function query($sql, $params = []){
        $stmt = $this->runSql($sql, $params);

        if($stmt->rowCount()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    /**
     * @param $sql
     * @param $params
     * @return bool|string
     */
    public function createQuery($sql, $params){
        $stmt = $this->runSql($sql, $params);
        if($stmt){
            return $this->db->lastInsertId();
        }
        return false;
    }
}