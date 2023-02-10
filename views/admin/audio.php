<?php
require_once('../common/header.php');
require_once('../../vendor/autoload.php');
$koneksi = testing();

$jumlahDataPerHalaman = 25;
$jumlahData = mysqli_num_rows(query("SELECT text_ayat FROM ayat"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

$halamanAktif = (isset($_GET['halaman'])) ? $_GET['halaman'] : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$tampilAudio = tampilAudio($awalData, $jumlahDataPerHalaman);
$tampilEditAudio = tampilAudio($awalData, $jumlahDataPerHalaman);
$tampilHapusAudio = tampilAudio($awalData, $jumlahDataPerHalaman);

//var untuk notifikasi
$notif = "";
$ket = "";

// Cek apakah button submit sudah diklik untuk menambahkan data
if (isset($_POST['tambah'])) {
    $id_ayat = $_POST['id_ayat'];
    $audio_ayat = $_POST['audio_ayat'];

    // Cek apakah data kosong atau tidak
    if ($id_ayat != null ) {
        $insertData = tambahAudio($id_ayat, $audio_ayat);
        $Data = mysqli_num_rows(query("SELECT audio_ayat FROM audio"));
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
    $id_audio = $_POST['id_audio'];
    $hapus_audio = hapusAudio($id_audio);
    $Data = mysqli_num_rows(query("SELECT audio_ayat FROM audio"));
    if ($Data < 1) {
        $notif = 'berhasil';
        $ket = "Dihapus";
    }
}

// Cek apakah button submit sudah diklik untuk ubah
if (isset($_POST['ubah'])) {
    $audio_ayat = $_POST['audio_ayat'];
    $id_audio = $_POST['id_audio'];
    // Cek apakah data kosong atau tidak
    if (
        $audio_ayat != null
    ) {
        $insertData = updateAudio($id_audio,$audio_ayat);
        $Data = mysqli_num_rows(query("SELECT audio_ayat FROM audio"));
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
                    <button type="button" class="btn btn-primary px-5 " data-bs-toggle="modal" data-bs-target="#tambah-audio">
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
                                    Audio Ayat
                                </th>
                                <th style="width: 6%;">
                                    Id Ayat
                                </th>
                                <th style="width: 10%;">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tampilAudio as $tampilAudio) : ?>
                                <tr>
                                    <td>
                                        <?= $tampilAudio['id_audio']; ?>
                                    </td>
                                    <td class="font-kitab style-ayah" style="font-size: 100%; ">
                                        <?= $tampilAudio['audio_ayat']; ?>
                                    </td>
                                    <td>
                                        <?= $tampilAudio['id_ayat']; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#edit-<?= $tampilAudio['id_audio'] ?>">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger ms-2 " data-bs-toggle="modal" data-bs-target="#hapus-<?= $tampilAudio['id_audio'] ?>">
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
        <div class="modal fade" id="tambah-audio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="row p-3">
                                <h2 class="col-12 text-center p-0" id="exampleModalLabel">Tambah Audio</h2>
                                <label for="id-ayat" class="col-12 fw-bold p-0 mt-2">
                                    <h5>Id Ayat</h5>
                                </label>
                                <input type="number" class="form-control" name="id_ayat" id="id-ayat"></input>
                                <label for="audio_ayat" class="col-12 fw-bold  p-0 mt-2">
                                    <h5>Audio Ayat</h5>
                                </label>
                                <textarea class="form-control" name="audio_ayat" id="audio_ayat" cols="30" rows="2"></textarea>
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
        <?php foreach ($tampilEditAudio as $tampilAudio) : ?>
            <div class="modal fade" id="edit-<?= $tampilAudio['id_audio'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="id_audio" value="<?= $tampilAudio['id_audio'] ?>">
                                    <label for="nomor-ayat" class="col-12 fw-bold p-0 mt-2">
                                        <h5>Id Ayat</h5>
                                    </label>
                                    <input type="number" class="form-control" name="id_ayat" value="<?= $tampilAudio['id_ayat'] ?>" id="id-ayat"></input>
                                    <label for="audio-ayat" class="col-12 fw-bold  p-0 mt-2">
                                        <h5>Audio Ayat</h5>
                                    </label>
                                    <textarea class="form-control" name="audio_ayat" id="audio-ayat" cols="30" rows="2"><?= $tampilAudio['audio_ayat'] ?></textarea>
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
        <?php foreach ($tampilHapusAudio as $tampilAudio) : ?>
            <div class="modal fade" id="hapus-<?= $tampilAudio['id_audio'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="" method="post" class="form-control">
                            <h3>Apakah Anda Yakin Akan Menghapus Data
                                <?= $tampilAudio['id_audio'] ?></h3>
                            <div class="modal-footer">
                                <input type="hidden" name="id_audio" value="<?= $tampilAudio['id_audio'] ?>">
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