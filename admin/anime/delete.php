<?php
require_once "../../libs/all.php";

$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method == 'POST') {
    $anime_id = $_POST['id'];

    global $connector;
    $anime_data = $connector->query("SELECT banner FROM animes WHERE id = $anime_id LIMIT 1")->fetch_array();
    if ($anime_data && $anime_data['banner']) {
        $banner_file = '../../uploads/' . $anime_data['banner'];

        if (file_exists($banner_file)) {
            unlink($banner_file);
        }
    }

    $connector->query("DELETE FROM anime_stream WHERE anime_id = $anime_id");
    $connector->query("DELETE FROM animes WHERE id = $anime_id");

    $flash->success('Data berhasil dihapus');

    redirect_to('/admin/anime');
}