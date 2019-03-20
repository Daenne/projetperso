<?php

class AProposController extends Controller
{

	public function showApropos($params)
    {
    	$pageTitle = 'A propos';

    	$this->render('AProposView.twig', array(
            'pageTitle' => $pageTitle
        ));

        //$myView = new View('AproposView');
        //$myView->render(array('pageTitle' => $pageTitle));
    }
}