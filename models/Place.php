<?php
namespace  models;

use core\Model;

class Place extends Model
{

    private $table = "places";

    private $id;
    private $place_name;
    private $state;
    private $state_abbreviation;
    private $longitude;
    private $latitude;
    private $zip_code;
    private $country_code;

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
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
    public function setAttributes($data){
        $this->place_name = $data["place_name"] ?:"";
        $this->state = $data["state"]?:"";
        $this->state_abbreviation = $data["state_abbreviation"]?:"";
        $this->longitude = $data["longitude"]?:"";
        $this->latitude = $data["latitude"]?:"";
        $this->zip_code = $data["zip_code"]?:"";
        $this->country_code = $data["country_code"]?:"";
    }
    /**
     * @param $zipCode
     * @param $countryCode
     * @return array
     */
    static public function all($zipCode,$countryCode){
        $_this = new self();
        $query = "select * from ".$_this->table." where country_code = :country_code and zip_code = :zip_code";
        return  $_this->db->query($query,[
            ":zip_code"=>$zipCode,
            ":country_code"=>$countryCode
        ]);
    }

    public function save(){
        $query = "INSERT INTO ".$this->table." SET"
            ." place_name = :place_name, "
            ." state = :state, "
            ." state_abbreviation = :state_abbreviation, "
            ." longitude = :longitude, "
            ." latitude = :latitude, "
            ." zip_code = :zip_code, "
            ." country_code = :country_code ;";
        return  $this->db->createQuery($query,[
            ":place_name"=>$this->place_name,
            ":state"=>$this->state,
            ":state_abbreviation"=>$this->state_abbreviation,
            ":longitude"=>$this->longitude,
            ":latitude"=>$this->latitude,
            ":zip_code"=>$this->zip_code,
            ":country_code"=>$this->country_code,
        ]);
    }

}