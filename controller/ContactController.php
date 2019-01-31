<?php

class ContactController 
{
	protected $form;

    public function __construct() {

        $this->form = new Contact();
    }
	public function showContact($params)
    {
    	$pageTitle = 'Contact';

        $myView = new View('ContactView');
        $myView->render(array('pageTitle' => $pageTitle));
    }

    public function sendMail($params)
    {		

    	extract($params);

    	if ((isset($user_name)) &&(fiter_var($user_mail, FILTER_VALIDATE_EMAIL))&& (isset($user_mail)) && (isset($user_message))) 
    	{
    		if ((!empty($user_name)) && (!empty($user_mail)) && (!empty($user_message))) 
    		{
    			$to = "belaib.charlotte@live.fr";
    			$subject = "Contact pro";
    			$message = "Un nouveau message est arrivé \n
    			Nom : $user_name \n
    			Email : $user_mail \n
    			Message : $user_message \n
    			";
    			$header = "From : $user_name \n Reply-to : $user_mail \n";

    			mail($to, $subject, $message, $header);



    			$pageTitle = 'Succès';

				$myView = new View('successView');
    			$myView->render(array('pageTitle' => $pageTitle));

    		}
    		else
    		{
    			echo "Vous n'avez pas rempli tous les champs";
    		}
    	}
    }
}