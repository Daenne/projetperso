<?php

class ContactController 
{
	public function showContact($params)
    {
        $myView = new View('ContactView');
        $myView->render();
    }
}