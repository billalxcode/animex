<?php

require_once dirname(__FILE__) . "/../vendor/autoload.php";
use Tamtamchik\SimpleFlash\Flash;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$flash = new Flash();

require_once dirname(__FILE__) . "/connector.php";
require_once dirname(__FILE__) . "/session.php";
require_once dirname(__FILE__) . "/utils.php";
?>