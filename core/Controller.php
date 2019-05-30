<?php
namespace core;

abstract class Controller{

    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
