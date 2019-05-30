<?php

namespace controllers;

use core\Controller;
use helpers\ZippopotamHelper;
use models\Place;
use models\Places;

class PlacesController extends Controller {

    public function index(){
        $cc = isset($_GET['cc']) ? $_GET['cc'] : null;
        $zc = isset($_GET['zc']) ? $_GET['zc'] : null;
        $result = Place::all($zc,$cc);
        if(!count($result)){
            $placesData = ZippopotamHelper::places($cc,$zc);
            $placesData = json_decode($placesData,true);
            if(count($placesData) && $placesData['places']){
                foreach ($placesData['places'] as $place){
                    $model = new Place();
                    $model->setAttributes([
                        "place_name"=>$place["place name"],
                        "state"=>$place["state"],
                        "state_abbreviation"=>$place["state abbreviation"],
                        "longitude"=>$place["longitude"],
                        "latitude"=>$place["latitude"],
                        "zip_code"=>$zc,
                        "country_code"=>$cc
                    ]);
                    $model->save();
                }
                $result = Place::all($zc,$cc);
                return response(["places"=>$result]);
            }
            else{
                return response(["places"=>[]]);
            }
        }
        return response(["places"=>$result]);
    }
}