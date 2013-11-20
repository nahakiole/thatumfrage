<?php
/**
 * Created by PhpStorm.
 * User: robin.glauser@gmail.com
 * Date: 12.11.13
 * Time: 19:50
 */

namespace Library;


class Logger {
    private static $logfile = 'log';

    public static function write($message){
        $fh = fopen('./'.self::$logfile, 'a') or die("can't open file");
        fwrite($fh, date('h:m').' '.$message."\n");
        fclose($fh);
    }

    public static function dump($arrMessage){
        $fh = fopen('./'.self::$logfile, 'a') or die("can't open file");
        fwrite($fh, var_export($arrMessage, true)."\n");
        fclose($fh);
    }
} 