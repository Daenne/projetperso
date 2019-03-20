<?php

require './vendor/autoload.php';

class Controller
{
	protected $table = [
		"HOST" => HOST,
        "VIEW" => VIEW,
		"WEB" => WEB
	];

    protected function render($view, $variables = [])
    {
    	$variables += $this->table;
        $loader = new Twig_Loader_Filesystem('view');
        $twig = new Twig_Environment($loader, [ 'cache' => false ]);
        echo $twig->render($view, $variables);
    }

    public function redirect($route) {

		header('Location:' . HOST . $route);

	}
}