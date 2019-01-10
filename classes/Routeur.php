<?php

class Routeur
{
	private $request;

    private $routes = [ 
                        "home" => ["controller" => 'HomeController', "method" =>'showHome'], 
                        "articles" => ["controller" => 'ArticlesController', "method" => 'showArticles'],
                        "article" => ["controller" => 'ArticlesController', "method" => 'showOneArticle'],
                        "contact" => ["controller" => 'HomeController', "method" => 'showContact']
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
        $elements = explode('/', $this->request);
        unset($elements[0]);

        for ($i=1; $i < count($elements) ; $i++) { 

            $params[$elements[$i]] = $elements[$i+1];
            $i++;
        }
        if (!isset($params)) {
            $params = null;
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

