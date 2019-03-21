<?php

class ContactController extends Controller
{
	public function showContact($params)
    {
    	$pageTitle = 'Contact';
        $recaptchaKeyPublic = '6LfzH5kUAAAAABamq998ii__Pmy5F2T7qJ0R2UY9';
        $this->render('ContactView.twig', array(
            'pageTitle' => $pageTitle,
            'recaptchaKey' => $recaptchaKeyPublic
        ));
    }

    public function sendMail($params)
    {		
    	extract($params);
        try
        {
            $recaptchaKeyPrivate = "6LfzH5kUAAAAAIYkm77DZnMiP77l4-5wOZPqTMVe";

            $response = $_POST['g-recaptcha-response'];
            $remoteip = $_SERVER['REMOTE_ADDR'];
            
            $api_url = "https://www.google.com/recaptcha/api/siteverify?secret=" 
                . $recaptchaKeyPrivate
                . "&response=" . $response
                . "&remoteip=" . $remoteip ;

            
            $decode = json_decode(file_get_contents($api_url), true);
            
            if ($decode['success'] == true) 
            {
                if((!empty($user_name)) && (!empty($user_mail)) && (!empty($user_message))) 
                {
                    if((isset($user_name)) && ((filter_var($user_mail, FILTER_VALIDATE_EMAIL)) != false) && (isset($user_mail)) && (isset($user_message)))
                    {
                        $mail = 'charlotte.debrou@gmail.com'; 

                        $line = "\n";

                        $message_txt = htmlspecialchars($user_message);
                        $message_html = "<html><head></head><body><b>Un utilisateur a cherché à vous contacter.</b><br/>Voici son message:
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
                    }
                    else
                    {
                        throw new Exception( 
                            "<br/><p class=\"container has-text-centered has-text-weight-bold\">Les données saisies ne sont pas valides. Retour au formulaire de contact <a href=\"contact\">ici</a></p>",
                            $this->render('Error.twig'));
                    }
                }
                else
                {
                    throw new Exception( 
                        "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous n'avez pas rempli tous les champs. Retour au formulaire de contact <a href=\"contact\">ici</a></p>",
                        $this->render('Error.twig'));                    
                }
            }
            else 
            {
                throw new Exception( 
                    "<br/><p class=\"container has-text-centered has-text-weight-bold\">Vous êtes un robot? Si ce n'est pas le cas, veuillez rééssayer. Retour au formulaire de contact <a href=\"contact\">ici</a></p>",
                    $this->render('Error.twig'));                
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
}