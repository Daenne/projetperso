<?php

class NewsletterController extends Controller
{
    public function subscribeNewsletter($params)
    {
      extract($params);

      if(!empty($user_mail_newsletter))
      {
        if(isset($user_mail_newsletter))
        {
          require_once('assets/MailChimp.php');        

            $MailChimp = new MailChimp('57ae29c9e2a5187e4715136f78e673de-us20');
            $list_id = 'd5f02829ed';

            $email = htmlspecialchars($_POST['user_mail_newsletter']);

            $result = $MailChimp->post("lists/$list_id/members", [
              'email_address' => $email,
              'status'        => 'subscribed',
            ]);

            $is_subscribed = 1;

            $pageTitle = 'Succès';

            $this->render('SuccessView.twig', array(
              'pageTitle' => $pageTitle
            ));
        }
        else
        {
          $is_subscribed = 0;
        }
      }
      else
      {
        throw new Exception(
          "<br/><p class=\"container has-text-centered has-text-weight-bold\">Si vous souhaitez vous inscrire à la newsletter, veuillez inscrire votre adresse mail.</p>",
            $this->render('Error.twig') 
        );        
      }
    } 
}