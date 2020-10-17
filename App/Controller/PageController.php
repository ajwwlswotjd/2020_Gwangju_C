<?php 

namespace Gondr\Controller;

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
		$this->render("festival");
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