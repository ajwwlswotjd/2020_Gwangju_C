<?php

namespace Gondr\Controller;
use Gondr\DB;
use Gondr\Lib;
use ZipArchive;

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

            
            $sql = "INSERT INTO `festival`(`id`, `no`, `name`, `location`, `start_date`, `end_date`, `content`, `imagePath` , `area`) VALUES (?,?,?,?,?,?,?,?,?)";
            $id = $item->sn;
            $no = $item->no;
            $name = $item->nm;
            $location = $item->location;
            $area = $item->area;
            
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
            
            
            DB::query( $sql, [ $id, $no, $name, $location, $start_date, $end_date, $content, $imagePath, $area ] );
            

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

    public function download()
    {
        $type = $_GET['type'];
        $id = $_GET['id'];

        $festival = DB::fetch("SELECT * FROM `festival` WHERE `id` = ?", [ $id ]);
        if(!$festival)
        {
            Lib::back("에반데 ㅋㅋ;");
            exit;
        }
        $imagePath = $festival->imagePath;
        $imgs = DB::fetchAll("SELECT * FROM `festival_imgs` WHERE `festival_id` = ?" , [ $id ]);
        $imgs = array_map(function($img){ return $img->name; } , $imgs );
        if(count($imgs) === 0)
        {
            Lib::back("첨부파일이 존재하지 않습니다.");
            exit;
        }

        $filePath = __ROOT.$festival->imagePath."/". time() . ".$type";
        echo $filePath;
        
        if($type==="zip")
        {

            // $zip = new ZipArchive();
            // $zip->open()

        }
        else if($type === "tar")
        {

        }
        else
        {
            Lib::back("타입이 잘못됬잖아 !!");
            exit;
        }

    }

}
