<?php

class HomeController extends Controller
{
  public function showHome($params) 
  {
  	$pageTitle = 'Accueil';

    $this->render('HomeView.twig', array(
      'pageTitle' => $pageTitle,
    ));
  }
}