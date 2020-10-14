<?php

namespace Gondr\Controller;

class MasterController {

    public function render( $view , $data = [] )
    {   
        extract($data);

        require (__ROOT . "/views/layout/header.php");
        require (__ROOT . "/views/". $view .".php");
        require (__ROOT . "/views/layout/footer.php");
    }

}