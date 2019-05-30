<?php

namespace helpers;

class ZippopotamHelper{

    private $ch;
    private $apiUrl = "http://api.zippopotam.us/";

    public function __construct()
    {
        $this->ch = curl_init();
        $this->apiUrl = "http://api.zippopotam.us/";
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);

    }

    static public function places($cc,$zc){
        $_this = new self();
        curl_setopt($_this->ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($_this->ch, CURLOPT_URL, $_this->apiUrl.$cc."/".$zc);
        $data = curl_exec($_this->ch);
        return $data;
    }

}