<?php

class AdminController extends Controller
{
	protected $manager;

    public function __construct() {

        $this->manager = new AdminManager();
    }

    public function showIndex($params)
    {
    	$pageTitle = 'Accueil';
      $this->render('HomeView.twig', array(
            'pageTitle' => $pageTitle
        ));
    }

    public function showLogin($params) 
  	{
      extract($params = array('pseudo' => $params['pseudo'], 'password' => $params['password']), EXTR_OVERWRITE);

  		if(isset($_SESSION['authentification']))
  		{
        $this->redirect('admin');
  		}
  		else 
  		{

  			if ((isset($params['pseudo'])) AND (isset($params['password']))) 
  			{
  				$this->getAdminConnexion(($params['pseudo']), ($params['password']));
  			}
  			else 
  			{	
  				$pageTitle = 'Login';

          $this->render('LoginView.twig', array(
                'pageTitle' => $pageTitle
            ));
  			}
  		}
  	}

  	public function showAdmin($params) 
  	{
  		if (isset($_SESSION['authentification'])) 
        {
          $articlesList = $this->manager->getAdminIndex();

          $tinyKey = 'vf59xyjgxn48ibyemdd9z3bljo7vnd99c667lokvdam3ykfi';

  			  $pageTitle = 'Administration';
          $this->render('AdminView.twig', array(
                'pageTitle'   => $pageTitle,
                'articlesList'=> $articlesList,
                'tinyKey' => $tinyKey
            ));
        }
        else 
        {
          $this->redirect('login');
        } 
  	}

  	public function getAdminConnexion ($pseudo, $password) 
  	{
  		try
  		{
  			$articlesList = $this->manager->getAdminIndex();
	        $result = $this->manager->adminConnexion($pseudo, $password);

	        $password == password_hash($password, PASSWORD_DEFAULT);
	        ($result['password']) == password_hash(($result['password']), PASSWORD_DEFAULT);

	        $isPseudoCorrect = strcmp($pseudo, $result['pseudo']);
	        $isPasswordCorrect = strcmp($password, $result['password']);

	        if (($isPseudoCorrect == 0) AND ($isPasswordCorrect == 0)) 
	        {
	          $_SESSION['authentification'] = true;
	          $pageTitle = 'Administration';
            $this->render('AdminView.twig', array(
                  'pageTitle'    => $pageTitle,
                  'articlesList' => $articlesList
              ));
	        }
	        else {
	           throw new Exception(
              "<br/><p class=\"container has-text-centered has-text-weight-bold\">Pseudo et/ou mot de passe incorrect(s). Retour à votre page <a href=\"login\">ici</a></p>",
              $this->render('Error.twig') 
             );
	        }
  		}
  		catch(Exception $e) 
		  { 
		    echo $e->getMessage();
		  }    
    }

    public function endAdmin($params)
    {
        if(isset($_SESSION['authentification']))
        {
          $_SESSION['authentification'] = false;
          session_unset();
          session_destroy();
          $this->showIndex($params);
        }
        else
        {
          $this->showIndex($params);
        }
    }

}