<?php

namespace Gondr\Controller;
use Gondr\DB;

class APIController extends MasterController {

    public function getFestivals()
    {

        $sql = "SELECT * FROM `festival`";
        $festivals = DB::fetchAll($sql);
        
        $festivals = array_map( function($festival){

            $imgs = DB::fetchAll("SELECT * FROM `festival_imgs` WHERE `festival_id` = ?" , [ $festival->id ]);
            $festival->imgs = array_map(function($img){
                return $img->name;
            },$imgs ? $imgs : []);
            return $festival;

        } , $festivals );

        echo json_encode(["festivals" => $festivals ] , JSON_UNESCAPED_UNICODE);
    }

}