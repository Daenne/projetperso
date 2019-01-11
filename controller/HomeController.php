<?php

class HomeController
{
  public function showHome($params) 
  {
  	$pageTitle = 'Accueil';

    $myView = new View('HomeView');
    $myView->render(array('pageTitle' => $pageTitle)); 
  }
}