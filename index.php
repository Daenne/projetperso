<?php

include_once('config/Configuration.php');

MyAutoLoad::start();

$request = $_GET['r'];

$routeur = new Routeur($request);
$routeur->renderController();

