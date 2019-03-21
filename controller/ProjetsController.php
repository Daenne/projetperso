<?php

class ProjetsController extends Controller
{
	public function showProjets($params)
    {
    	$pageTitle = 'Projets';

    	$this->render('ProjetsView.twig', array(
            'pageTitle' => $pageTitle
        ));
    }
}