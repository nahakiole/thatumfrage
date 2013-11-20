<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 05.11.13
 * Time: 10:50
 */

namespace Controller;

require_once './controller/Request.php';

class App {

    public $request;

    public function __construct(){
        $this->request = new Request();
    }
}