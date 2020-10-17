<?php

namespace Gondr\Controller;
use Gondr\DB;

class DataController extends MasterController {


    public function init()
    {
        echo "<pre>";    
        $xml_dir = __ROOT . "\\resrc\\festivalList.xml";
        $default_path = dirname(__ROOT) . "\\festivalImages";

        $data = simplexml_load_file($xml_dir);
        

        DB::query("DELETE FROM `festival` WHERE 1");
        DB::query("DELETE FROM `festival_imgs` WHERE 1");


        foreach( $data->items->item as $item )
        {

            
            $sql = "INSERT INTO `festival`(`id`, `no`, `name`, `location`, `start_date`, `end_date`, `content`, `imagePath`) VALUES (?,?,?,?,?,?,?,?)";
            $id = $item->sn;
            $no = $item->no;
            $name = $item->nm;
            $location = $item->location;
            
            $date = $item->dt;
            $date = str_replace(".","-",$date);
            $date_arr = explode("~" , $date);

            if( count($date_arr) != 2 ){
                $location = $item->dt;
                $date = $item->location;
                $date_arr = explode("~" , $date);
            }

            $start_date = $date_arr[0];
            $end_date = $date_arr[1];

            if( strlen($end_date) != 5 ){
                $end_arr = explode( "-" , $end_date );
                $end_date = $end_arr[1] . "-" . $end_arr[2];
            }

            $content = $item->cn;
            $imagePath = $default_path . "\\" . str_pad( $item->sn , 3 , "0" , STR_PAD_LEFT ) . "_" . $item->no;
            
            
            DB::query( $sql, [ $id, $no, $name, $location, $start_date, $end_date, $content, $imagePath ] );
            

            $flag = null;
            foreach( $item->images->image as $img )
            {
                $src = $imagePath . "\\" . $img;
                $sql = "INSERT INTO `festival_imgs`(`idx`, `festival_id`, `name`) VALUES (null,?,?)";
                $cnt = DB::query($sql, [ $id, $src ]);
                if($cnt != 1) $flag = $cnt;
            }
            echo $flag === null ? ($id . " 업로드 완료") : ( $id . "번 문제 발생" );
            echo "<br>";



        }

    
        // var_dump($data);
        echo "</pre>";


    }

}