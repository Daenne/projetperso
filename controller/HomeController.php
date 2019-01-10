<?php

class HomeController
{

    public function showHome($params) 
    {

        $myView = new View('HomeView');
        $myView->render(); 
    }

    public function showContact($params)
    {
        $myView = new View('ContactView');
        $myView->render();
    }
    
 //   protected $controller;

 //   function __construct()
 //   {
 //       $this->controller = new HomeModel();
 //   }

  //  public function getIndex()
  //  {
   //     echo "coucou controler";
   //     $articlesList = $this->controller->getArticles();
   //     require('./view/HomeWiew.php');
    //}
}