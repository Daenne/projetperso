<?php

class HomeController
{
  public function showHome($params) 
  {
    $myView = new View('HomeView');
    $myView->render(); 
  }
}