<?php require_once('common/header.php') ?>
<?php require_once('../vendor/autoload.php');
$koneksi = koneksi();
$parser = new AlQuranCloud\Tools\Parser\Tajweed(); ?>

<!-- content -->
<div class="container-fluid pt-5">
    <main class="container mt-5 mb-5 py-3 px-5">
        <?php for ($i = 1; $i <= 114; $i++) : ?>
            <?php
            $sql = "SELECT ayat.unicode_tajwid, 
                                ayat.text_ayat, 
                                ayat.nomor_ayat, 
                                ayat.id_ayat, 
                                ayat.id_halaman,  
                                terjemahan.text_terjemah, 
                                audio.audio_ayat, 
                                surah.nomor_surah, 
                                surah.nama_surah 
                                FROM ayat, terjemahan, audio, surah 
                                WHERE ayat.id_ayat=terjemahan.id_terjemah 
                                AND ayat.id_ayat=audio.id_ayat 
                                AND ayat.id_surah=surah.id_surah 
                                AND ayat.id_surah =  $i";

            $query = mysqli_query($koneksi, $sql);
            $nama_surah = mysqli_fetch_assoc($query);
            ?>
            <div class="row my-3" style="border-radius:20px; background-color:#ebeff1;">
                <div class="border">
                    <h3 class="text-center mt-3"><?= $nama_surah['nama_surah'] ?></h3>
                </div>
                <?php foreach ($query as $query) : ?>
                    <?php
                    $number = $query['nomor_ayat'];
                    $audio = $query['audio_ayat'];
                    $terjemahan = $query['text_terjemah'];
                    $text = $query['text_ayat'];
                    $surah = $query['nama_surah'];

                    $ayat = json_decode($query['unicode_tajwid']);
                    ?>

                    <div class="d-flex flex-wrap" style="direction: rtl;">
                        <span class=" font-uthmani style-ayah mt-1 m-0" style="direction: rtl;  font-size: 200%;">
                            <?= $parser->parse($ayat) ?>
                        </span>
                        <p class="p-2 d-flex align-items-center mx-3 justify-content-center text-white rounded-3" style="background-color:grey; height:30px;">
                        <?=penomoranAyat($number);?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </main>
</div>