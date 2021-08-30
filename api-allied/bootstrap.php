<?php

error_reporting(E_ALL & ~E_NOTICE);

require_once ('vendor/autoload.php');

// Carrega dados do aquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once ('Src/routes.php');