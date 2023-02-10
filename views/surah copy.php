<?php require_once('common/header.php') ?>

<?php require_once('../vendor/autoload.php'); ?>

<?php

if (isset($_GET['nama_surah'])) {
    $nama = $_GET['nama_surah'];
    $nama_surah = addslashes($nama);
    $nama_surah = $nama_surah;
} else {
    $url = 'http://localhost/tajwid-quran/';
    header("Location:.$url");
}
$sql = "SELECT id_surah FROM surah WHERE nama_surah = '$nama_surah'";
$query = mysqli_query($koneksi, $sql);
$id_surah = mysqli_fetch_assoc($query);
$id_surah = $id_surah['id_surah'];
$sql = "SELECT ayat.unicode_tajwid, 
            ayat.text_ayat, 
            ayat.nomor_ayat, 
            ayat.id_halaman,  
            terjemahan.text_terjemah, 
            audio.audio_ayat, 
            surah.nomor_surah, 
            surah.nama_surah,
            surah.terjemah_surah, 
            latin.translate_indo
            FROM ayat, terjemahan, audio, surah, latin 
            WHERE ayat.id_ayat=terjemahan.id_terjemah 
            AND ayat.id_ayat=audio.id_ayat 
            AND ayat.id_surah=surah.id_surah 
            AND latin.id_ayat = ayat.id_ayat 
            AND ayat.id_surah =  $id_surah";

$query = mysqli_query($koneksi, $sql);
$parser = new AlQuranCloud\Tools\Parser\Tajweed();

?>

<!-- content -->
<section class="container-fluid pt-5">
    <main class="container mt-lg-5 mt-3  " style="border-radius:20px; background-color:#ebeff1; ">
        <div class="row mb-2 ">
            <div class="col-lg-3  col-md-3 d-none d-lg-block d-md-block">
                <h3 class="text-center mt-3">DAFTAR SURAH</h3>
            </div>
            <div class="col-lg-7 col-md-7  offset-lg-1 offset-md-1">
                <div class="lead font-kitab align-center">
                    <h3 class="text-center mt-3 ">
                        بِسْمِ ٱللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <form action="" class="col-lg-3 col-md-3" method="GET">
                <?php $tampilData = "SELECT id_surah,nama_surah FROM surah;" ?>
                <?php $ambilData = mysqli_query($koneksi, $tampilData); ?>
                <div class="d-flex">
                    <select name="nama_surah" class="form-select" aria-label="Default select example">

                        <?php foreach ($ambilData as $data) : ?>
                            <option <?php if ($nama_surah === addslashes($data['nama_surah'])) echo "selected"; ?> value="<?php echo $data['nama_surah'] ?>"><?= $data['nama_surah']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn ms-2 text-white " style="background-color: #198754;">cari</button>
                </div>

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
                                    <?php $surah = mysqli_fetch_assoc($query); ?>
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
                                    <?php $a = "SELECT id_ayat FROM ayat WHERE id_surah = $id_surah"; ?>
                                    <?php $proses = mysqli_query($koneksi, $a); ?>
                                    <?php $proses = mysqli_num_rows($proses); ?>
                                    <?= $proses; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Surah Ke
                                </td>
                                <td>
                                    <?= $surah['nomor_surah'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="col-lg-8 col-md-8">
                <div class="row border" style="height: 100vh;">
                    <div class="col-lg-12 col-md-12 overflow-auto" style="height: 100vh;">
                        <?php foreach ($query as $query) : ?>
                            <div class="row ">
                                <div class="col pt-1">
                                    <?php $audio = $query['audio_ayat']; ?>
                                    <?php $nomor = $query['nomor_ayat']; ?>
                                    <?php $terjemah = $query['text_terjemah']; ?>
                                    <?php $ayat = json_decode($query['unicode_tajwid']); ?>
                                    <div class="shadow bg-white px-3">
                                        <div class="font-kitab m-0 style-ayah pt-3 rounded-3" style="direction: rtl;  font-size: 200%;">
                                            <?= $parser->parse($ayat) ?>
                                        </div>
                                        <div class="pb-1 mt-1">
                                            <i class="fs-5 mb-0  text-start "><?= $query['translate_indo'] ?></i>
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
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </main>
</section>

<?php require_once('common/footer.php'); ?>