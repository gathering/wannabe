<?php

class WbLog
{
    public static function log($type, $message){
        CakeLog::config('default', array('engine' => 'File'));
        CakeLog::write($type, $message);
    }

}