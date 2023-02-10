<?php require_once('common/header.php') ?>
<?php require_once('../vendor/autoload.php');
$parser = new AlQuranCloud\Tools\Parser\Tajweed();
$koneksi = koneksi();
use AlQuranCloud\Tools\Renderer\Generic; ?>

<!-- content -->
<div class="container-fluid pt-5">
    <main class="container mt-5 mb-5 py-3 px-5">
        <?php for ($i = 1; $i <= 10; $i++) : ?>
            <?php
            $sql = "SELECT * FROM ayat WHERE id_ayat = $i";

            $query = mysqli_query($koneksi, $sql);
            // $nama_surah = mysqli_fetch_assoc($query);
            ?>
            <div class="row my-3" style="border-radius:20px; background-color:#ebeff1;">
                <?php foreach ($query as $query) : ?>
                    <?php

                    $ayat = $query['text_ayat'];
                    // $ayat = str_replace("\\", "\\\\", $ayat);
                    ($ayat);
                    $kalimat = $ayat;
                    $dicari = "ا";
                    if (preg_match("/$dicari/i", $kalimat)) {
                        $replace = str_replace($dicari, "[n:1[ٱ]", $kalimat);
                        $replace = str_replace("\\\\", "\\", $replace);

                        echo $replace;
                        echo "<br>";
                        echo "<br>";
                        echo $ayat;
                    } else {
                        echo 'Kata <b>' . $dicari . '</b> tidak ditemukan.';
                    }
                    $ayat = json_decode($replace);
                    ?>

                    <div class="d-flex" style="direction: rtl;">
                        <span class=" font-kitab style-ayah mt-1" style="direction: rtl;  font-size: 200%;">
                            <?php echo($parser->parse($replace)) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endfor; ?>
    </main>
</div>