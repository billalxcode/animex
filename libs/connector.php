<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "cretoo";
$port = 3306;

$connector = new mysqli(
    hostname: $hostname,
    username: $username,
    password: $password,
    database: $database,
    port: $port
);

if ($connector->connect_errno) {
    die('Database gagal terkoneksi');
}