<?php
require "../../libs/all.php";
require_once "validation.php";

function saveBeritaData($title, $banner, $content, $created_by)
{
    global $connector;
    $query = "INSERT INTO news (title, image, content, created_by, created_at) VALUES ('$title', '$banner', '$content', $created_by, NOW())";

    $connector->query($query);
    return true;
}

function handleFileUpload($file, $upload_dir = "../../uploads")
{
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $random_filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $target_file = $upload_dir . '/' . $random_filename;
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $random_filename;
    } else {
        return null;
    }
}

$request_method = $_SERVER['REQUEST_METHOD'];
$errors = [];

if ($request_method == "POST") {
    $title = $_POST['title'];
    $banner = $_FILES['banner'];
    $content = htmlspecialchars($_POST['content']);

    $created_by = getLoginData('id');

    $titleError = validateTitle($title);
    $bannerError = validateBanner($banner);

    if ($titleError) {
        $flash->error($titleError);
    }
    if ($bannerError) {
        $flash->error($bannerError);
    }

    if (!$titleError && !$bannerError) {
        $banner_name = handleFileUpload($banner);

        if ($banner_name) {
            if (saveBeritaData($title, $banner_name, $content, $created_by)) {
                redirect_to("index.php");
            } else {
                $flash->error('Gagal menyimpan data ke database');
            }
        } else {
            $flash->error('Gagal mengupload file banner');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Cretoo</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../static/assets/css/bs.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css">

    <style>
        .ck-editor__editable {
            height: 400px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include("../layout/navbar.php") ?>
    <div id="layoutSidenav">
        <?php include("../layout/sidebar.php") ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Berita</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Tambah Data</li>
                    </ol>

                    <?= $flash->display() ?>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-plus me-1"></i>
                            Data Baru
                        </div>
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="form-group mb-3">
                                    <label for="title">Judul</label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Masukan Judul">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="banner">Banner</label>
                                    <input type="file" name="banner" id="banner" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" class="form-control"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <button class="btn btn-primary btn-sm d-flex gap-2 align-items-center"><i class="fa fa-save"></i>Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Billal Fauzan 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/scripts.js"></script>

    <script type="importmap">
        {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/43.2.0/"
                }
            }
        </script>
    <script type="module">
        import {
            ClassicEditor,
            Essentials,
            Paragraph,
            Bold,
            Italic,
            Font
        } from 'ckeditor5';

        ClassicEditor
            .create(document.querySelector('#content'), {
                plugins: [Essentials, Paragraph, Bold, Italic, Font],
                toolbar: [
                    'undo', 'redo', '|', 'bold', 'italic', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <!-- A friendly reminder to run on a server, remove this during the integration. -->
    <script>
        window.onload = function() {
            if (window.location.protocol === "file:") {
                alert("This sample requires an HTTP server. Please serve this file with a web server.");
            }
        };
    </script>
</body>

</html>