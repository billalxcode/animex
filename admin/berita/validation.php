<?php
require "../../libs/all.php";
// Fungsi validasi untuk judul
function validateTitle($title)
{
    if (empty($title)) {
        return "Judul tidak boleh kosong.";
    }
    if (strlen($title) < 3) {
        return "Judul harus memiliki setidaknya 3 karakter.";
    }
    return null; // Tidak ada kesalahan
}

// Fungsi validasi untuk nama episode
function validateStreamName($stream_name)
{
    if (empty($stream_name)) {
        return "Nama stream tidak boleh kosong";
    }
    if (strlen($stream_name) < 2) {
        return "Nama stream harus memiliki setidaknya 3 karakter";
    }

    return null;
}

// Fungsi validasi untuk banner
function validateBanner($banner)
{
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if ($banner['error'] !== UPLOAD_ERR_OK) {
        return "Gagal mengupload banner.";
    }

    if (!in_array($banner['type'], $allowed_types)) {
        return "Tipe file banner tidak valid. Harus JPEG, PNG, atau GIF.";
    }

    if ($banner['size'] > 5 * 1024 * 1024) { // 2MB max size
        return "Ukuran file terlalu besar. Maksimal 5MB.";
    }

    return null; // Tidak ada kesalahan
}

// Fungsi validasi untuk stream_url
function validateStreamUrl($stream_url)
{
    if (empty($stream_url)) {
        return "Stream URL tidak boleh kosong.";
    }
    if (!filter_var($stream_url, FILTER_VALIDATE_URL)) {
        return "Format Stream URL tidak valid.";
    }
    return null; // Tidak ada kesalahan
}
