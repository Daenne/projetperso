<?php

class AdminController 
{
	protected $manager;

    public function __construct() {

        $this->manager = new AdminManager();
    }

    public function showIndex($params)
    {
    	$pageTitle = 'Accueil';

    	$myView = new View('HomeView');
    	$myView->render(array('pageTitle' => $pageTitle)); 
    }

    public function showLogin($params) 
  	{
  		var_dump($params);
  		extract($params); //réécrit variables

  		//essayer
  		// $values = $_POST['values'];
  		// $manager = new DevinetteManager();
  		// $manager->create($values);
  		// myView = new View();
  		// myView->redirect('home');

  		if(isset($_SESSION['authentification']))
  		{
  			$articlesList = $this->manager->getAdminIndex();
  			$pageTitle = 'Administration';
  			$myView = new View();
            $myView->redirect('admin');
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

    			$myView = new View('LoginView');
    			$myView->render(array('pageTitle' => $pageTitle)); 
    			
  			}
  		}
  	}

  	public function showAdmin($params) 
  	{
  		//var_dump($params);
  		if (isset($_SESSION['authentification'])) 
        {
           	$articlesList = $this->manager->getAdminIndex();
  			$pageTitle = 'Administration';

    		$myView = new View('AdminView');
    		$myView->render(array('articlesList' => $articlesList, 'pageTitle' => $pageTitle)); 
        }
        else 
        {
        	$pageTitle = 'Login';
  			$myView = new View();
            $myView->redirect('login');
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
	            
	          	$myView = new View('AdminView');
	    		$myView->render(array('articlesList' => $articlesList, 'pageTitle' => $pageTitle));   

	        }
	        else {
	           throw new Exception("<p>Pseudo et/ou mot de passe incorrect(s). Retour à la page d'accueil <a href=\"home\">ici</a></p>");
	        }
  		}
  		catch(Exception $e) 
		{ 
		    echo 'Erreur : ' . $e->getMessage();
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