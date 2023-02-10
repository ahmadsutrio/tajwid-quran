<?php
require_once('../common/header.php');
require_once('../../vendor/autoload.php');
$koneksi = testing();

$jumlahDataPerHalaman = 25;
$jumlahData = mysqli_num_rows(query("SELECT text_ayat FROM ayat"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$tampilAyat = tampilAyat($awalData, $jumlahDataPerHalaman);
$tampilEditAyat = tampilAyat($awalData, $jumlahDataPerHalaman);
$tampilHapusAyat = tampilAyat($awalData, $jumlahDataPerHalaman);

// foreach($getHalaman as $getHalaman){
//     echo $getHalaman['halaman'];
// }
//var untuk notifikasi
$notif = "";
$ket = "";

// Cek apakah button submit sudah diklik untuk menambahkan data
if (isset($_POST['tambah'])) {
    $id_surah = $_POST['id_surah'];
    $id_halaman = $_POST['id_halaman'];
    $text_ayat = $_POST['text_ayat'];
    $nomor_ayat = $_POST['nomor_ayat'];
    $unicode_ayat = $_POST['unicode_ayat'];
    $unicode_tajwid = $_POST['unicode_tajwid'];

    // Cek apakah data kosong atau tidak
    if (
        $id_surah != null
        and $id_halaman != null
        and $text_ayat != null
        and $nomor_ayat != null
        and $unicode_ayat != null
        and $unicode_tajwid != null
    ) {
        $insertData = tambahAyat($id_surah, $id_halaman, $text_ayat, $nomor_ayat, $unicode_ayat, $unicode_tajwid);
        $Data = mysqli_num_rows(query("SELECT text_ayat FROM ayat"));
        if ($Data > 1) {
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
    $id_ayat = $_POST['id_ayat'];
    $hapus_ayat = hapusAyat($id_ayat);
    $Data = mysqli_num_rows(query("SELECT text_ayat FROM ayat"));
    if ($Data > 1) {
        $notif = 'berhasil';
        $ket = "Dihapus";
    }
}

// Cek apakah button submit sudah diklik untuk ubah
if (isset($_POST['ubah'])) {
    $id_ayat = $_POST['id_ayat'];
    $id_surah = $_POST['id_surah'];
    $id_halaman = $_POST['id_halaman'];
    $text_ayat = $_POST['text_ayat'];
    $nomor_ayat = $_POST['nomor_ayat'];
    $unicode_ayat = $_POST['unicode_ayat'];
    $unicode_tajwid = $_POST['unicode_tajwid'];

    // Cek apakah data kosong atau tidak
    if (
        $id_ayat != null
    ) {
        $insertData = updateAyat($id_ayat, $id_surah, $id_halaman, $text_ayat, $nomor_ayat, $unicode_ayat, $unicode_tajwid);
        $Data = mysqli_num_rows(query("SELECT text_ayat FROM ayat"));
        if ($Data > 1) {
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
                    <button type="button" class="btn btn-primary px-5 " data-bs-toggle="modal" data-bs-target="#tambah-ayat">
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
                                    Ayat
                                </th>
                                <th style="width: 3%;">
                                    Surah
                                </th>
                                <th style="width: 3%;">
                                    Halaman
                                </th>
                                <th style="width: 10%;">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tampilAyat as $tampilAyat) : ?>
                                <tr>
                                    <td>
                                        <?= $tampilAyat['id_ayat']; ?>
                                    </td>
                                    <td class="font-kitab style-ayah" style="font-size: 100%; ">
                                        <?= $tampilAyat['text_ayat']; ?>
                                    </td>
                                    <td>
                                        <?= $tampilAyat['id_surah']; ?>
                                    </td>
                                    <td>
                                        <?= $tampilAyat['id_halaman']; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#edit-<?= $tampilAyat['id_ayat'] ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger ms-2 " data-bs-toggle="modal" data-bs-target="#hapus-<?= $tampilAyat['id_ayat'] ?>">
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

        <!-- Modal Edit -->
        <div class="modal fade" id="tambah-ayat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="row p-3">
                                <h2 class="col-12 text-center p-0" id="exampleModalLabel">Tambah Ayat</h2>
                                <label for="nomor-ayat" class="col-12 fw-bold p-0 mt-2">
                                    <h5>Nomor Ayat</h5>
                                </label>
                                <input type="number" class="form-control" name="nomor_ayat" id="nomor-ayat"></input>
                                <label for="ayat" class="col-12 fw-bold  p-0 mt-2">
                                    <h5>Ayat</h5>
                                </label>
                                <textarea class="form-control" name="text_ayat" id="ayat" cols="30" rows="2"></textarea>
                                <label for="unicode_ayat" class="col-12 fw-bold  p-0 mt-2">
                                    <h5>Unicode Ayat</h5>
                                </label>
                                <textarea class="form-control" name="unicode_ayat" id="unicode_ayat" cols="30" rows="2"></textarea>
                                <label for="unicode_tajwid" class="col-12 fw-bold  p-0 mt-2">
                                    <h5>Unicode Tajwid</h5>
                                </label>
                                <textarea class="form-control" name="unicode_tajwid" id="unicode_tajwid" cols="30" rows="2"></textarea>
                                <label for="Surah" class="col-12 fw-bold  p-0 mt-2">
                                    <h5>Surah</h5>
                                </label>
                                <select class="form-select" aria-label="Default select example" name="id_surah" id="Surah">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <label for="Halaman" class="col-12 fw-bold  p-0 mt-2">
                                    <h5>Halaman</h5>
                                </label>
                                <select class="form-select" aria-label="Default select example" name="id_halaman" id="Halaman">
                                    <option selected>Open this select menu</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>

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

        <!-- Edit Ayat -->
        <?php foreach ($tampilEditAyat as $tampilAyat) : ?>
            <div class="modal fade" id="edit-<?= $tampilAyat['id_ayat'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id_ayat" value="<?= $tampilAyat['id_ayat'] ?>">
                                    <label for="nomor-ayat" class="col-12 fw-bold p-0 mt-2">
                                        <h5>Nomor Ayat</h5>
                                    </label>
                                    <input type="number" class="form-control" name="nomor_ayat" value="<?= $tampilAyat['nomor_ayat'] ?>" id="nomor-ayat"></input>
                                    <label for="ayat" class="col-12 fw-bold  p-0 mt-2">
                                        <h5>Ayat</h5>
                                    </label>
                                    <textarea class="form-control" name="text_ayat" value="<?php $tampilAyat['text_ayat'] ?> id=" ayat" cols="30" rows="2"><?= $tampilAyat['text_ayat'] ?></textarea>
                                    <label for="unicode_ayat" class="col-12 fw-bold  p-0 mt-2">
                                        <h5>Unicode Ayat</h5>
                                    </label>
                                    <textarea class="form-control" name="unicode_ayat" id="unicode_ayat" cols="30" rows="2"><?= $tampilAyat['unicode_ayat'] ?></textarea>
                                    <label for="unicode_tajwid" class="col-12 fw-bold  p-0 mt-2">
                                        <h5>Unicode Tajwid</h5>
                                    </label>
                                    <textarea class="form-control" name="unicode_tajwid" id="unicode_tajwid" cols="30" rows="2"><?= $tampilAyat['unicode_tajwid'] ?></textarea>
                                    <label for="Surah" class="col-12 fw-bold  p-0 mt-2">
                                        <h5>Surah</h5>
                                    </label>
                                    <select class="form-select" aria-label="Default select example" name="id_surah" id="Surah">
                                        <?php $getSurah = getSurah(); ?>
                                        <?php foreach ($getSurah as $getSurah) : ?>
                                            <!-- <option selected>Open this select menu</option> -->
                                            <option <?php if ($tampilAyat['id_surah'] == $getSurah['id_surah']) echo "selected"; ?> value="<?= $getSurah['id_surah']; ?>"><?= $getSurah['nama_surah']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label for="Halaman" class="col-12 fw-bold  p-0 mt-2">
                                        <h5>Halaman</h5>
                                    </label>
                                    <select class="form-select" aria-label="Default select example" name="id_halaman" id="Halaman">
                                        <?php $getHalaman = getHalaman(); ?>
                                        <?php foreach ($getHalaman as $getHalaman) : ?>
                                            <!-- <option selected>Open this select menu</option> -->
                                            <option <?php if ($tampilAyat['id_halaman'] == $getHalaman['id_halaman']) echo "selected"; ?> value="<?= $getHalaman['id_halaman']; ?>"><?= $getHalaman['halaman']; ?></option>
                                        <?php endforeach; ?>
                                    </select>

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
        <?php foreach ($tampilHapusAyat as $tampilAyat) : ?>
            <div class="modal fade" id="hapus-<?= $tampilAyat['id_ayat'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="post" class="form-control">
                            <h3>Apakah Anda Yakin Akan Menghapus Data
                                <?= $tampilAyat['id_ayat'] ?></h3>
                            <div class="modal-footer">
                                <input type="hidden" name="id_ayat" value="<?= $tampilAyat['id_ayat'] ?>">
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