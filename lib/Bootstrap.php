<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 12.11.13
 * Time: 18:41
 */

namespace Library;


class Bootstrap {

    static function getAlert($message,$type = 'warning'){
        return '<div class="alert alert-'.$type.'">'.$message.'</div>';
    }
} 