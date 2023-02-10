<?php
require_once('../common/header.php');
require_once('../../vendor/autoload.php');
$koneksi = testing();

$jumlahDataPerHalaman = 25;
$jumlahData = mysqli_num_rows(query("SELECT halaman FROM halaman"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$tampilHalaman = tampilHalaman($awalData, $jumlahDataPerHalaman);
$tampilEditHalaman = tampilHalaman($awalData, $jumlahDataPerHalaman);
$tampilHapusHalaman = tampilHalaman($awalData, $jumlahDataPerHalaman);

//var untuk notifikasi
$notif = "";
$ket = "";

// Cek apakah button submit sudah diklik untuk menambahkan data
if (isset($_POST['tambah'])) {
    $halaman = $_POST['halaman'];

    // Cek apakah data kosong atau tidak
    if ( $halaman != null) {
        $insertData = tambahHalaman( $halaman);
        $Data = mysqli_num_rows(query("SELECT halaman FROM halaman"));
        if ($Data >= 1) {
            $notif = 'berhasil';
            $ket = "Ditambahkan";
        }
    } else {
        $notif = "gagal";
        $ket = "Ditambahkan";
    }
} else {
    $notif = "";
    $ket = "";
}

// Cek apakah konfirmasi hapus telah diclik 
if (isset($_POST['hapus'])) {
    $id_halaman = $_POST['id_halaman'];
    $hapusHalaman = hapusHalaman($id_halaman);
    $Data = mysqli_num_rows(query("SELECT id_halaman FROM halaman"));
    if ($Data >= 1) {
        $notif = 'berhasil';
        $ket = "Dihapus";
    }
}

// Cek apakah button submit sudah diklik untuk ubah
if (isset($_POST['ubah'])) {
    $id_halaman = $_POST['id_halaman'];
    $halaman = $_POST['halaman'];

    // Cek apakah data kosong atau tidak
    if ($halaman != null) {
        $updateHalaman = updateHalaman($id_halaman, $halaman);
        $Data = mysqli_num_rows(query("SELECT halaman FROM halaman"));
        if ($Data >= 1) {
            $notif = 'berhasil';
            $ket = "Diubah";
        }
    } else {
        $notif = "gagal";
        $ket = "DiUbah";
    }
} else {
    $notif = "";
    $ket = "";
}

?>

<section class="container-fluid pt-5 position-relative ">
    <main class="container mt-lg-5 mt-3 " style="border-radius:20px; ">

        <!-- Alert -->
        <div class="col-12">
            <?php if ($notif == 'berhasil') : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Data Berhasil <?= $ket; ?></strong> Data Anda berhasil <?= $ket; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($notif == 'gagal') : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Data Gagal <?= $ket; ?></strong> Inputan yang anda masukan kosong atau tidak sesuai
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php else : ?>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-12 mb-2">
                <form action="" class="text-end">
                    <button type="button" class="btn btn-primary px-5 " data-bs-toggle="modal" data-bs-target="#tambah-halaman">
                        Tambah
                    </button>
                </form>
            </div>
            <div class="col-12">
                <div class="table-responsive overflow-auto border rounded-3">
                    <table class="table table-striped  border-dark table-light table-hover" style="border-radius: 10px;">
                        <thead>
                            <tr>
                                <th class="py">
                                    No
                                </th>
                                <th>
                                    Halaman
                                </th>
                                <th style="width: 10%;">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tampilHalaman as $tampilHalaman) : ?>
                                <tr>
                                    <td>
                                        <?= $tampilHalaman['id_halaman']; ?>
                                    </td>
                                    <td class="font-kitab style-ayah" style="font-size: 100%; ">
                                        <?= $tampilHalaman['halaman']; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#edit-<?= $tampilHalaman['id_halaman'] ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger ms-2 " data-bs-toggle="modal" data-bs-target="#hapus-<?= $tampilHalaman['id_halaman'] ?>">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal tambah -->
        <div class="modal fade" id="tambah-halaman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="row p-3">
                                <h2 class="col-12 text-center p-0" id="exampleModalLabel">Tambah Halaman</h2>
                                <label for="nomor-halaman" class="col-12 fw-bold p-0 mt-2">
                                    <h5>Nomor dan Nama Halaman</h5>
                                </label>
                                <input type="text" class="form-control" name="halaman" id="nomor-halaman"></input>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="" name="tambah">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Halaman -->
        <?php foreach ($tampilEditHalaman as $tampilHalaman) : ?>
            <div class="modal fade" id="edit-<?= $tampilHalaman['id_halaman'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id_halaman" value="<?= $tampilHalaman['id_halaman'] ?>">
                                    <label for="nomor-halaman" class="col-12 fw-bold p-0 mt-2">
                                        <h5>Nama dan Nomor Halaman</h5>
                                    </label>
                                    <input type="text" class="form-control" name="halaman" value="<?= $tampilHalaman['halaman'] ?>" id="nomor-halaman">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="ubah" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Modal Hapus -->
        <?php foreach ($tampilHapusHalaman as $tampilHalaman) : ?>
            <div class="modal fade" id="hapus-<?= $tampilHalaman['id_halaman'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="post" class="form-control">
                            <h3>Apakah Anda Yakin Akan Menghapus Data
                                <?= $tampilHalaman['id_halaman'] ?></h3>
                                <input type="hidden" name="id_halaman" value="<?= $tampilHalaman['id_halaman'] ?>">
                            <div class="modal-footer">
                                <button class="btn btn-danger" type="submit" name="hapus">Oke</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination border overflow-auto">
                <?php if ($halamanAktif > 1) : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">Previous</a></li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                    <?php if ($i == $halamanAktif) : ?>
                        <li class="page-item"><a class="page-link fw-bold active" href="?halaman=<?= $i ?>"><?= $i ?></a></li>
                    <?php else : ?>
                        <li class="page-item "><a class="page-link " href="?halaman=<?= $i ?>"><?= $i ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($halamanAktif < $jumlahHalaman) : ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </main>
</section>

<?php require_once('../common/footer.php') ?>