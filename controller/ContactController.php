<?php

class ContactController extends Controller
{
	//protected $form;

    //public function __construct() {

    //    $this->form = new Contact();
    //}
	public function showContact($params)
    {
    	$pageTitle = 'Contact';
        $this->render('ContactView.twig', array(
            'pageTitle' => $pageTitle
        ));
        //$myView = new View('ContactView');
        //$myView->render(array('pageTitle' => $pageTitle));
    }

    public function sendMail($params) //revoir erreur mailsend lors eerreur
    {		

    	extract($params);

        try
        {
            if((!empty($user_name)) && (!empty($user_mail)) && (!empty($user_message))) 
            {
                if((isset($user_name)) && ((filter_var($user_mail, FILTER_VALIDATE_EMAIL)) != false) && (isset($user_mail)) && (isset($user_message)))
                {
                    $mail = 'charlotte.debrou@gmail.com'; 

                    $line = "\n";

                    $message_txt = htmlspecialchars($user_message);
                    $message_html = "<html><head></head><body><b>Un utilisateur a cherché à vous contacter.</b>, voici son message:
                                    <p>". htmlspecialchars($user_message)."</p></body></html>";

                    $boundary = "-----=".md5(rand());

                    $subject = "Contact professionnel";

                    $header = "From: \"<".htmlspecialchars($user_name).">\"<".$user_mail.">".$line;
                    $header.= "Reply-to: \"<".htmlspecialchars($user_name).">\" <".$user_mail.">".$line;
                    $header.= "MIME-Version: 1.0".$line;
                    $header.= "Content-Type: multipart/alternative;".$line." boundary=\"$boundary\"".$line;

                    $message = $line."--".$boundary.$line;
                    //Txt
                    $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$line;
                    $message.= "Content-Transfer-Encoding: 8bit".$line;
                    $message.= $line.$message_txt.$line;
                    $message.= $line."--".$boundary.$line;
                    //HTML
                    $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$line;
                    $message.= "Content-Transfer-Encoding: 8bit".$line;
                    $message.= $line.$message_html.$line;
                    $message.= $line."--".$boundary."--".$line;
                    $message.= $line."--".$boundary."--".$line;
                     
                    mail($mail,$subject,$message,$header);
                    
                    $pageTitle = 'Succès';
                    $this->render('SuccessView.twig', array(
                        'pageTitle' => $pageTitle
                    ));
                    //$myView = new View('successView');
                    //$myView->render(array('pageTitle' => $pageTitle));

                }
                else
                {
                    throw new Exception( 
                          "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas rempli tous les champs. Retour au formulaire de contact <a href=\"contact\">ici</a></p>",
                          $this->render('Error.twig') 
                    );
                }
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}