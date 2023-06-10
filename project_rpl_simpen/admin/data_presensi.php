<?php
session_start();
if (empty($_SESSION['username'])) {
    header("location:index.php?message=belum_login");
}

if (isset($_GET['message'])) {
    if ($_GET['message'] == 'hapus_gagal') {
?>
        <script>
            alert("Data tidak dapat dihapus, karena masih terdaftar di table lain!");
        </script>
<?php
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
    <title>Sistem Monitoring Pendidikan</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>
<style>
    #tableklinik {

        border: 1px solid black;
        border-collapse: collapse;

    }
</style>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <img src="../assets/school.png" width="50px" class="icon d-inline-block align-center ms-2 me-2" alt="">
        <a class="navbar-brand ps-1" href="dashboard.php">Admin</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                    <li><a class="dropdown-item" href="../operation/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="admin-user row">
                    <center>
                        <img src="../assets/profile.png" width="100px" alt="">
                        <h6>Admin</h6>
                    </center>
                </div>
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Main Menu</div>
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Data</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Input Data
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="input_siswa.php">Siswa</a>
                                <a class="nav-link" href="input_presensi.php">Presensi</a>
                                <a class="nav-link" href="input_nilai.php">Nilai</a>
                                <a class="nav-link" href="input_mapel.php">Mata Pelajaran</a>
                                <a class="nav-link" href="input_guru.php">Guru</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#viewData" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            View Data
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="viewData" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="data_orangtua.php">Data Orangtua</a>
                                <a class="nav-link" href="data_siswa.php">Data Siswa</a>
                                <a class="nav-link" href="data_presensi.php">Data Presensi</a>
                                <a class="nav-link" href="data_nilai.php">Data Nilai</a>
                                <a class="nav-link" href="data_mapel.php">Data Mata Pelajaran</a>
                                <a class="nav-link" href="data_guru.php">Data Guru</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data_Presensi</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Presensi
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Jumlah Sakit</th>
                                        <th>Jumlah Alfa</th>
                                        <th>Jumlah Izin</th>
                                        <th colspan="2">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include '../connection/connection.php';
                                    $sql = "SELECT presensi.id, presensi.jml_sakit, presensi.jml_alfa, presensi.jml_izin, siswa.nama
                                    FROM presensi
                                    INNER JOIN siswa ON siswa.nisn = presensi.nisn_siswa;";
                                    $no = 1;
                                    $query = mysqli_query($connect, $sql);
                                    while ($data_presensi = mysqli_fetch_array($query)) {
                                    ?>
                                        <tr>
                                            <td><?= $data_presensi['nama'] ?></td>
                                            <td><?= $data_presensi['jml_sakit'] ?></td>
                                            <td><?= $data_presensi['jml_alfa'] ?></td>
                                            <td><?= $data_presensi['jml_izin'] ?></td>
                                            <td><a type="submit" href="edit_presensi.php?id=<?= $data_presensi['id'] ?>" class="btn"><img src="../assets/user.png" width="25px" alt=""></a></td>
                                            <td> <a type="submit" href="../operation/delete.php?id=<?= $data_presensi['id'] ?>" class="btn"><img src="../assets/delete.png" width="25px" alt=""></a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">&copy; copyright 2022 by anonymous</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

</body>

</html>