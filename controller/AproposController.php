<?php

class AproposController 
{
	public function showApropos($params)
    {
    	$pageTitle = 'A propos';

        $myView = new View('AproposView');
        $myView->render(array('pageTitle' => $pageTitle));
    }
}