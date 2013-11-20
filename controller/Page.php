<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 12.11.13
 * Time: 10:42
 */

namespace Controller;


abstract class Page {
    public $variables = Array();
    public $pageTheme;

    abstract function getPage();

    public function setVariables($variables){
        $this->variables = array_merge($this->variables ,$variables);
    }

    public function setVariable($key, $value){
        $this->variables[$key] = $value;
    }
} 