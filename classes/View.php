<?php

class View {

	private $template;

	public function __construct($template = null) {

		$this->template = $template;
	}

	public function render($params = array()) {

		extract($params);

		$template = $this->template;
		ob_start();
		include_once(VIEW.$template.'.php');
		$contentPage = ob_get_clean();
		include_once(VIEW.'gabarit.php');

	}

	public function redirect($route) {

		header('Location:' . HOST . $route);

	}
}