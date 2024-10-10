<?php
require_once dirname(__FILE__) . '/../libs/all.php';

$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method == 'POST') {
    clearLoginSession();
    $flash->success('Logout berhasil');
    redirect_to('/admin/login.php');
}