<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 05.11.13
 * Time: 10:42
 */

namespace Controller;


use Library\Logger;

/**
 * Class Template
 *
 * @package Controller
 */
class Template {

    public static  $theme = 'default';
    private $baseTheme =  'index.html';
    private $pageTheme =  'content.html';
    private $variables =  Array();
    public  $pageVariables =  Array();

    public function __construct($theme = 'default'){
        self::$theme = $theme;
    }

    public function setBaseTheme($baseTheme){
        $this->baseTheme = $baseTheme;
    }

    public function setPageTheme($pageTheme){
        $this->pageTheme = $pageTheme;
    }

    public function setVariables($variables){
        $this->variables = array_merge($this->variables ,$variables);
    }

    public function setVariable($key, $value){
        $this->variables[$key] = $value;
    }

    public function render(){
        //\Library\Logger::dump($this->pageVariables);
        //s\Library\Logger::dump($this->variables);
        $baseThemeFile = file_get_contents('./view/'.self::$theme .'/'.$this->baseTheme, FILE_USE_INCLUDE_PATH);
        $pageThemeFile = file_get_contents('./view/'.self::$theme .'/'.$this->pageTheme, FILE_USE_INCLUDE_PATH);
        foreach ($this->pageVariables as $replace => $value){
            $pageThemeFile = str_replace('[['.$replace.']]',$value, $pageThemeFile);
        }
        $this->variables['CONTENT'] = $pageThemeFile;
        foreach ($this->variables as $replace => $value){
            $baseThemeFile = str_replace('[['.$replace.']]',$value, $baseThemeFile);
        }
        $baseThemeFile = preg_replace("/\[\[.*\]\]/",'',$baseThemeFile);
        return $baseThemeFile;
    }

} 