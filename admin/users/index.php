<?php
require "../../libs/all.php";

$users_data = $connector->query("SELECT * FROM users WHERE role = 'user'");
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
                    <h1 class="mt-4">Pengguna</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Data</li>
                    </ol>

                    <?= $flash->display() ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            Menu Shortcut
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-3">
                                <a href="/admin/berita/tambah-data.php" class="btn btn-primary btn-sm">Tambah Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Semua Pengguna
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php while ($user = $users_data->fetch_assoc()) { ?>
                                        <tr>
                                            <td>
                                                <?= $user['nama'] ?>
                                            </td>
                                            <td>
                                                <?= hide_string($user['email']) ?>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="/admin/user/edit.php?id=<?= $user['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    <form action="/admin/user/delete.php" method="post" id="formDeleteuser-<?= $user['id'] ?>">
                                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                    </form>
                                                    <a href="#" onclick="document.getElementById('formDeleteuser-<?= $user['id'] ?>').submit()" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
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