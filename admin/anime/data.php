<?php
require "../../libs/all.php";
require_once "validation.php";

$data_id = $_GET['id'];
if (is_null($data_id)) {
    redirect_to('index.php');
}

$anime_data = $connector->query("SELECT * FROM animes WHERE id = $data_id LIMIT 1")->fetch_array();
$streams_data = $connector->query("SELECT * FROM anime_stream WHERE anime_id = $data_id");

function saveStreamData($stream_name, $stream_url, $anime_id)
{
    global $connector;
    $query = "INSERT INTO anime_stream (stream_name, stream_url, anime_id, created_at) VALUES ('$stream_name', '$stream_url', $anime_id, NOW())";

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
    $stream_name = $_POST['stream_name'];
    $stream_url = $_POST['stream_url'];

    $stream_name_error = validateStreamName($stream_name);
    $stream_url_error = validateStreamUrl($stream_url);

    if ($stream_name_error) {
        $flash->error($stream_name_error);
    }
    if ($stream_url_error) {
        $flash->error($stream_url_error);
    }

    if (!$stream_name_error && !$stream_url_error) {
        if (saveStreamData($stream_name, $stream_url, $data_id)) {
            redirect_to("data.php?id=$data_id");
        } else {
            $flash->error('Gagal menyimpan data ke database');
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
</head>

<body class="sb-nav-fixed">
    <?php include("../layout/navbar.php") ?>
    <div id="layoutSidenav">
        <?php include("../layout/sidebar.php") ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Anime</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">List dan Tambah Episode - <?= $anime_data['title'] ?? 'unknown' ?></li>
                    </ol>

                    <?= $flash->display() ?>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-plus me-1"></i>
                                    Episode
                                </div>
                                <div class="card-body">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group mb-3">
                                            <label for="stream_name">Nama Episode</label>
                                            <input type="text" name="stream_name" id="stream_name" class="form-control" placeholder="Masukan Episode">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="stream_url">Stream URL</label>
                                            <input type="text" name="stream_url" id="stream_url" class="form-control" placeholder="Masukan URL">
                                        </div>
                                        <div class="form-group mb-3">
                                            <button class="btn btn-primary btn-sm d-flex gap-2 align-items-center"><i class="fa fa-save"></i>Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fa fa-database"></i>
                                    Episode
                                </div>
                                <div class="card-body">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>Nama Episode</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nama Episode</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php while ($stream = $streams_data->fetch_assoc()) { ?>
                                                <td><?= $stream['stream_name'] ?></td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            // Simple-DataTables
            // https://github.com/fiduswriter/Simple-DataTables/wiki

            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
    </script>
</body>

</html>