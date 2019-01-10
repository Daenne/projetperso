<?php

class AproposController 
{
	public function showApropos($params)
    {
        $myView = new View('AproposView');
        $myView->render();
    }
}