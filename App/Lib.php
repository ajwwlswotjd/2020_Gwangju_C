<?php

namespace Gondr;

class Lib {

    public static function validate($data , $list)
    {
        foreach($list as $key)
        {
            if( !isset( $data[$key]) || $data[$key] == "" ) self::back("필수값이 비어있습니다.");
        }
    }

    public static function back($msg)
    {
        echo "<script>";
        if($msg !== null) echo "alert('$msg');";
        echo "history.back();";
        echo "</script>";
    }

    public static function move($link , $msg)
    {
        echo "<script>";
        if($msg !== null) echo "alert('$msg');";
        echo "location.href = '$link'";
        echo "</script>";       
    }
    
}