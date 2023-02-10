<?php require_once('common/header.php') ?>
<?php require_once('../vendor/autoload.php'); ?>

<?php
$ayat = 1;

if (isset($_GET['nama_surah'])) {
    $nama = $_GET['nama_surah'];
    $nama_surah = addslashes($nama);
    $id_surah = getIdSurah($nama_surah);
    $totalAyat = cariSurah($id_surah);
    $tampilSurah = cariSurah($id_surah);
} else if (isset($_GET['surah']) and isset($_GET['ayat'])) {
    $nama = $_GET['surah'];
    $nama_surah = $nama;
    $id_surah = getIdSurah($nama_surah);
    $totalAyat = cariSurah($id_surah);
    $ayat = $_GET['ayat'];
    $tampilSurah = getAyat($ayat, $id_surah);
} else {
    $url = 'http://localhost/tajwid-quran/';
    header("Location:.$url");
}
// function yang digunakan
$totalSurah = totalSurah();
$ambilJumlahAyat = getJumlahAyat($id_surah);
$parser = new AlQuranCloud\Tools\Parser\Tajweed();

?>

<!-- content -->
<section class="container-fluid pt-5">
    <main class="container mt-lg-5 mt-3  " style="border-radius:20px; background-color:#ebeff1; ">
        <div class="row mb-2 justify-content-center">
            <div class="col-12">
            </div>
            <div class="col-lg-3 col-md-3 d-none d-lg-block d-md-block">
                <h1 class="fw-bold text-center mt-3" style="color:#198754;">Qur'an<span style="color: #212529;">Ku</span></h1>
            </div>
            <div class="col-lg-7 col-md-7  offset-lg-1 offset-md-1">
                <div class="align-center">
                    <h3 class="text-center mt-4 ">
                        <h1 class="fw-bold text-center mt-3" style="color:#198754;"><?=$a = stripslashes($nama)?></h1>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row mt-lg-3 justify-content-center">
            <div class="col-lg-3 col-md-3">
                <h5 class=" mb-2 text-muted">Daftar Surah</h5>
                <form action="" method="GET">
                    <div class="d-flex">
                        <select name="nama_surah" class="form-select" aria-label="Default select example">
                            <?php foreach ($totalSurah as $data) : ?>
                                <option <?php if ($nama_surah === addslashes($data['nama_surah'])) echo "selected"; ?> value="<?php echo $data['nama_surah'] ?>"><?= $data['nama_surah']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn ms-2 text-white " style="background-color: #198754;">cari</button>
                    </div>
                </form>
                <h5 class=" mt-2 text-muted">Daftar Ayat</h5>
                <form action="" class="mt-2" method="get">
                    <div class="d-flex">
                        <input type="hidden" name="surah" value="<?= $nama_surah ?>">
                        <select name="ayat" class="form-select" aria-label="Default select example">
                            <?php foreach ($ambilJumlahAyat as $data) : ?>
                                <option <?php if ($ayat === ($data['nomor_ayat'])) echo "selected"; ?> value="<?php echo $data['nomor_ayat'] ?>"><?= $data['nomor_ayat']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn ms-2 text-white " style="background-color: #198754;">cari</button>
                    </div>
                </form>
                <form action="" class="mt-2" method="get">
                    <input type="hidden" name="nama_surah" value="<?= stripslashes($nama_surah) ?>">
                    <button type="submit" class="btn ms-2 text-white " style="background-color: #198754;">Tampil Semua Ayat</button>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover table-bordered border-dark bg-white">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    KETERANGAN
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Nama Surah
                                </td>
                                <td>
                                    <?php $surah = mysqli_fetch_assoc($tampilSurah); ?>
                                    <?= $surah['nama_surah']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Arti Surah
                                </td>
                                <td>
                                    <?= $surah['terjemah_surah']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Jumlah Ayat
                                </td>
                                <td>
                                    <?php $proses = mysqli_num_rows($totalAyat); ?>
                                    <?= $proses; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Surah ke
                                </td>
                                <td>
                                    <?= $surah['nomor_surah'] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Halaman
                                </td>
                                <td>
                                    <?= $surah['id_halaman'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>


            <div class="col-lg-8 col-md-8">
                <div class="row border" style="height: 100vh;">
                    <div class="col-lg-12 col-md-12 overflow-auto" style="height: 100vh;">
                        <div class="row ">
                            <?php if ($surah['nama_surah'] !== 'Al-Fatihah') : ?>
                                <div class="col-12 ">
                                    <div class="shadow bg-white px-3">
                                        <div class="lead font-kitab align-center py-3 rounded-3">
                                            <h3 class="text-center ">
                                                بِسْمِ ٱللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php foreach ($tampilSurah as $query) : ?>
                                <div class="col-12 pt-1">
                                    <?php $audio = $query['audio_ayat']; ?>
                                    <?php $nomor = $query['nomor_ayat']; ?>
                                    <?php $terjemah = $query['text_terjemah']; ?>
                                    <?php $ayat = json_decode($query['unicode_tajwid']); ?>
                                    <div class="shadow bg-white px-3">
                                        <div class="font-kitab m-0 style-ayah pt-3 rounded-3" style="direction: rtl;  font-size: 200%;">
                                            <?= $parser->parse($ayat) . " " . penomoranAyat($nomor) ?>
                                        </div>
                                        <div class="pb-1 mt-1">
                                            <i class="fs-5 mb-0  text-start mt-1 text-muted "><?= $query['translate_indo'] ?></i>
                                            <p class="fs-5 text-start mt-1"><?= $terjemah ?></p>
                                            <div class="d-flex">
                                                <span class="fs-6 border justify-content-start rounded-3 text-end px-2 text-white m-0 mb-1" style="background-color: #198754;"><?= $nomor ?></span>
                                            </div>
                                            <hr class="m-0">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <audio id="ayahPlayer" controls="controls" class="align-center my-auto py-2">
                                                        <source id="activeAyah" src="<?= $audio ?>" type="audio/ogg" />
                                                        <source id="activeAyah" src="<?= $audio ?>" type="audio/mp3" />
                                                    </audio>
                                                </div>
                                                <!-- <div class="d-flex">
                                                    <div class="d-flex me-2">
                                                        <p class="text-muted">Ayat ke:</p>
                                                    </div>
                                                    <span class="fs-6 border justify-content-start rounded-3 text-end px-2 text-white m-0 mb-1" style="background-color: #198754;"><?= $nomor ?></span>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</section>

<?php require_once('common/footer.php'); ?>