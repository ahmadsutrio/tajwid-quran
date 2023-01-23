<?php require_once('../vendor/autoload.php'); ?>
<?php use AlQuranCloud\Tools\Renderer\Generic; ?>
<?php require_once('common/header.php'); ?>
<?php require_once('common/navigation.php'); ?>
<?php require_once('koneksi.php');
$koneksi = koneksi();
?>
<?php // ================================================================ // ?>



<!-- <link href="/public/css/tajweed.css" rel="stylesheet"> -->
<link href="https://alquran.cloud/public/css/font-all.css" rel="stylesheet">
<link href="../public/css/tajweed.css" rel="stylesheet">

<div class="container" style="border: solid 1px #d6d6d6;">
    <div class="lead font-kitab align-center">

        <h3 class="text-center">
        بِسْمِ ٱللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </h3>
    </div>
	<div class="row">
		<div class="col-md-12">
        <h3 class="text-center mb-5">Deteksi Tajwid <br> An-Nur </h3>
        <br>
        <br>
        <!-- <br> -->
        
        <?php
        // for ($i = 0; $i <= 6235; $i++) : 
            $sql = "SELECT ayat.unicode_tajwid, ayat.text_ayat, ayat.nomor_ayat,  terjemahan.text_terjemah, audio.audio_ayat, surah.nomor_surah, surah.nama_surah FROM ayat, terjemahan, audio, surah WHERE ayat.id_ayat=terjemahan.id_terjemah AND ayat.id_ayat=audio.id_ayat AND ayat.id_surah=surah.id_surah AND ayat.id_surah= 24;";
            ?>
            <?php
            $query = mysqli_query($koneksi, $sql); 
            ?>

            
            
                
<?php
         $parser = new AlQuranCloud\Tools\Parser\Tajweed();
         
         foreach ($query as $ayat) { 
            // hanya untuk menandai saja
            $number = $ayat['nomor_ayat'];
            $audio = $ayat['audio_ayat'];
            $terjemahan = $ayat['text_terjemah'];
            $text = $ayat['text_ayat'];
             
             $ayat = json_decode($ayat['unicode_tajwid']);
             //  =====================
             $arabicNum = '<span style="padding: 0 15px 0 15px; background-color:grey; border-radius: 10px; color: white; margin-right: 5px;" >'.Generic::latinToArabicNumerals($number).'</span>';
             ?>
            
            <div class="font-kitab style-ayah pt-5" style="direction: rtl;  font-size: 270%;">
                <?=$parser->parse($ayat).$arabicNum?>
                <br>
         </div>
         <div style="width: 700px; margin-top: 20px;">

                <span style="padding: 2px; color: black; font-size: 20px; margin-right: 5px; line-height: 5px;" ><?=$terjemahan?></span>
                <br>
                <audio id="ayahPlayer" controls="controls" class="align-right" style="padding-top: 20px;">
                <source
                id="activeAyah"src="<?=$audio?>" type="audio/mp3" />
            </audio>               
                </div>
                <br>
            <br>
            <hr>
            <?php } ?>

            
<!-- <div class="playerBar" style="bottom: 0; margin-bottom: 60px; position: fixed; width: 30%; z-index: 1000; border: black solid 2px;">                 -->
<!-- <div class="row" id="surahConfigurator"> -->
<!-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> -->

  <!-- </div>
  </div>
  </div> -->

                   

            <!-- TABEL PENJELASAN -->

        <h5>What do the Colours mean?</h5>
        <table class="table table-responsive table-bordered">
    <thead>
        <tr>
            <th>Type</th>
            <th>Identifier</th>
            <th>Colour</th>
            <th>CSS</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($parser->getMeta() as $meta) { ?>
            <tr>
                <td><?=$meta['type'];?></td>
                <td><?=$meta['identifier'];?></td>
                <td style="background-color: <?=$meta['html_color'];?>; color: white;"><?=$meta['html_color'];?></td>
                <td><?=$meta['default_css_class'];?></td>
                <td><?=$meta['description'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
    <p>
        Essentially, all that's happening here is that [h:9421[ٱ] which is returned by the API for the above Vese becomes:
        <pre>&lt;tajweed class="ham_wasl" data-type="hamza-wasl" data-description="Hamzat ul Wasl" data-tajweed=":9421"&gt;ٱ&lt;/tajweed&gt;</pre>
    </p>
    </div>
        </div>


</div>
<script src="../public/js/jquery.mediaplayer.js?v=14"></script>
<script src="../public/js/jquery.surah.js?v=7"></script>

<script>
$(function() {
	$('#editionSelector').multiselect({ enableFiltering: true, enableCaseInsensitiveFiltering: true, maxHeight: 400, dropUp: true});
	$.alQuranSurah.editions('#editionSelector', '<?= $surah->data->number; ?>');
	$.alQuranSurah.surahs('#surahSelector');
	$.alQuranMediaPlayer.init($("#surahPlayer")[0], 'surah', <?=$ayahs[0]->number?>, <?=end($ayahs)->number?>, <?=$surah->data->number?>, 0);
    $.alQuranMediaPlayer.defaultPlayer();
    $.alQuranMediaPlayer.zoomIntoThisAyah();
});
</script>



<?php // ================================================================ // ?>
<?php require_once('common/footer.php'); ?>
