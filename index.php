<?php
require_once __DIR__.'/autoload.php';
session_start();

$front = FrontController::getInstance();
$front->route();


