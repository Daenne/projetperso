<?php

class ProjetsController 
{
	public function showProjets($params)
    {
        $myView = new View('ProjetsView');
        $myView->render();
    }
}