<?php

class Routeur extends Controller
{
	private $request;

    private $routes = [ 
                        ""         => ["controller" => 'HomeController',     "method" =>'showHome'],
                        "index"    => ["controller" => 'HomeController',     "method" =>'showHome'],
                        "home"     => ["controller" => 'HomeController',     "method" =>'showHome'], 
                        "articles" => ["controller" => 'ArticlesController', "method" => 'showArticles'],

                            "subscribe"      => ["controller" => 'ArticlesController', "method" => 'subscribeNewsletter'],

                            "article"        => ["controller" => 'ArticlesController', "method" => 'showOneArticle'],
                            "write"          => ["controller" => 'ArticlesController', "method" => 'addArticle'],
                            "rewrite"        => ["controller" => 'ArticlesController', "method" => 'rewriteArticle'],
                            "edit"           => ["controller" => 'ArticlesController', "method" => 'editArticle'],
                            "delete"         => ["controller" => 'ArticlesController', "method" => 'deleteArticle'],

                            "addComment"     => ["controller" => 'ArticlesController', "method" => 'addComment'],
                            "warningComment"=> ["controller" => 'ArticlesController', "method" => 'signaledComment'],

                        "projets"  => ["controller" => 'ProjetsController',  "method" => 'showProjets'],
                        "apropos"  => ["controller" => 'AProposController',  "method" => 'showApropos'],
                        "contact"  => ["controller" => 'ContactController',  "method" => 'showContact'],
                        "mailSend" => ["controller" => 'ContactController',  "method" => 'sendMail'],

                        "login"         => ["controller" => 'AdminController',    "method" => 'showLogin'],
                        "logout"        => ["controller" => 'AdminController',    "method" => 'endAdmin'],
                        "admin"         => ["controller" => 'AdminController',    "method" => 'showAdmin'],
                        
                        "adminComment"  => ["controller" => 'ArticlesController', "method" => 'getAllComments'],
                        "deleteComment" => ["controller" => 'ArticlesController', "method" => 'deleteComment'],
                        "validComment"  => ["controller" => 'ArticlesController', "method" => 'acceptedComment']
                    ]; // [url name who gives controller name]

	public function __construct($request)
	{
		$this->request = $request;
	}

    public function getRoute() 
    {
        $elements = explode('/', $this->request);
        return $elements[0];
    }

    public function getParams() 
    {
        $params = null;

        //extract $_GET

        $elements = explode('/', $this->request);
        unset($elements[0]);

        for ($i=1; $i < count($elements) ; $i++) { 

            $params[$elements[$i]] = $elements[$i+1];
            $i++;
        }

        //extract $_POST

        if ($_POST) {
           foreach ($_POST as $key => $value) {
               $params[$key] = $value;
           }
        }
        return $params;
    }

	public function renderController() {

        $route = $this->getRoute();
        $params = $this->getParams();

    //$request = $this->request;
        try
        {
            if(key_exists($route, $this->routes)) 
            {
                $controller = $this->routes[$route]['controller'];
                $method = $this->routes[$route]['method'];

                $currentController = new $controller();
                $currentController->$method($params);
            }
            else 
            {
                throw new Exception(
                    "<br/><p class=\"container has-text-centered has-text-weight-bold\"><span class=\"is-size-1\">404</span><br/>Retour à la page d'accueil <a href=\"home\">ici</a></p>",
                    $this->render('Error.twig') 
            );   
            }
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }

	}
}

