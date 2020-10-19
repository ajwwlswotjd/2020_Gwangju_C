<?php 

namespace Gondr\Controller;
use Gondr\DB;


class PageController extends MasterController {

	public function index()
	{
		$this->render("main");
	}

	public function exchangeRate()
	{
		$this->render("exchangeRate");		
	}

	public function rep_festival()
	{

		$festivals = DB::fetchAll("SELECT * FROM `festival`", []);
		$festivals = array_map( function($festival){

			$imgs = DB::fetchAll("SELECT * FROM `festival_imgs` WHERE `festival_id` = ?" , [ $festival->id ] );
			$festival->imgs = array_map(function($img){
				return $img->name;
			},$imgs);
			return $festival;

		} , $festivals );

		$this->render("festival" , ["festivals"=>$festivals]);
	}

	public function notice()
	{
		$this->render("notice");
	}

	public function join()
	{
		$this->render("join");
	}

	public function login()
	{
		$this->render("login");
	}

	

}