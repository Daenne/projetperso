<?php

class Routeur
{
	private $request;

    private $routes = [ 
                        ""         => ["controller" => 'HomeController',     "method" =>'showHome'],
                        "index"    => ["controller" => 'HomeController',     "method" =>'showHome'],
                        "home"     => ["controller" => 'HomeController',     "method" =>'showHome'], 
                        "articles" => ["controller" => 'ArticlesController', "method" => 'showArticles'],

                            "subscribe"      => ["controller" => 'ArticlesController', "method" => 'subscribeNewsletter'],
                            "sendNewsletter" => ["controller" => 'ArticlesController', "method" => 'sendNewsletter'],
                            "unsubscribe"    => ["controller" => 'ArticlesController', "method" => 'unsubscribeNewsletter'],

                            "article"        => ["controller" => 'ArticlesController', "method" => 'showOneArticle'],
                            "write"          => ["controller" => 'ArticlesController', "method" => 'addArticle'],
                            "rewrite"        => ["controller" => 'ArticlesController', "method" => 'rewriteArticle'],
                            "edit"           => ["controller" => 'ArticlesController', "method" => 'editArticle'],
                            "delete"         => ["controller" => 'ArticlesController', "method" => 'deleteArticle'],

                            "addComment"=>["controller" => 'ArticlesController', "method" => 'addComment'],

                        "projets"  => ["controller" => 'ProjetsController',  "method" => 'showProjets'],
                        "apropos"  => ["controller" => 'AproposController',  "method" => 'showApropos'],
                        "contact"  => ["controller" => 'ContactController',  "method" => 'showContact'],
                        "mailSend" => ["controller" => 'ContactController',  "method" => 'sendMail'],

                        "login"    => ["controller" => 'AdminController',    "method" => 'showLogin'],
                        "logout"   => ["controller" => 'AdminController',    "method" => 'endAdmin'],
                        "admin"    => ["controller" => 'AdminController',    "method" => 'showAdmin']
                    ]; // [nom du lien qui intégre nom du controller]

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
    if(key_exists($route, $this->routes)) 
    {
        $controller = $this->routes[$route]['controller'];
        $method = $this->routes[$route]['method'];

        $currentController = new $controller();
        $currentController->$method($params);
    }
    else 
    {
        echo "Erreur 404";
    }
	}
}

