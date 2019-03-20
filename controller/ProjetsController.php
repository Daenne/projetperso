<?php

class ProjetsController extends Controller
{
	public function showProjets($params)
    {
    	$pageTitle = 'Projets';

    	$this->render('ProjetsView.twig', array(
            'pageTitle' => $pageTitle
        ));


        //$myView = new View('ProjetsView');
        //$myView->render(array('pageTitle' => $pageTitle));
    }
}