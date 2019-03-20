<?php

include_once('config/Configuration.php');

MyAutoLoad::start();

if (isset($_GET['r'])) {
	$request = $_GET['r'];
}
else
{
	$request = null;
}

$routeur = new Routeur($request);
$routeur->renderController();
