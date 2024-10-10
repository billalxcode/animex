<?php
require_once "../../libs/all.php";

$request_method = $_SERVER['REQUEST_METHOD'];

if ($request_method == 'POST') {
    $berita_id = $_POST['id'];

    global $connector;
    $berita_data = $connector->query("SELECT image FROM news WHERE id = $berita_id LIMIT 1")->fetch_array();
    if ($berita_data && $berita_data['image']) {
        $image_file = '../../uploads/' . $berita_data['image'];

        if (file_exists($image_file)) {
            unlink($image_file);
        }
    }

    $connector->query("DELETE FROM news WHERE id = $berita_id");

    $flash->success('Data berhasil dihapus');

    redirect_to('/admin/berita');
}
