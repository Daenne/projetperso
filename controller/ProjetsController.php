<?php

class ProjetsController 
{
	public function showProjets($params)
    {
    	$pageTitle = 'Projets';

        $myView = new View('ProjetsView');
        $myView->render(array('pageTitle' => $pageTitle));
    }
}