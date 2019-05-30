<?php

namespace  core;

use database\DB;

abstract class Model{

    public $db;
    public function __construct()
    {
        $this->db = new  DB();
    }
}