<?php require_once('../../../autoload.php'); ?>
<?php use AlQuranCloud\Tools\Renderer\Generic; ?>
<?php require_once('common/header.php'); ?>
<?php require_once('common/navigation.php'); ?>
<?php require_once('koneksi.php');
$koneksi = koneksi();
?>
<?php // ================================================================ // ?>



<!-- <link href="/public/css/tajweed.css" rel="stylesheet"> -->
<link href="https://alquran.cloud/public/css/font-all.css" rel="stylesheet">
<link href="css/tajweed.css" rel="stylesheet">

<div class="container">
    <div class="lead font-kitab align-center">

        <h3 class="text-center">
        بِسْمِ ٱللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
        </h3>
    </div>
	<div class="row">
		<div class="col-md-12">
        <h3 class="text-center mb-5">Deteksi Tajwid <br> 30 juz </h3>
        <br>
        <br>
        <!-- <br> -->
        
        <?php
        for ($i = 0; $i <= 6235; $i++) : 
            $sql = "SELECT * FROM ayat WHERE id = $i;" 
            ?>
            <?php
            $query = mysqli_query($koneksi, $sql); 
            ?>

            
            
        <?php
         $parser = new AlQuranCloud\Tools\Parser\Tajweed();
         
         foreach ($query as $ayat) { 
            // hanya untuk menandai saja
             $text = $ayat['text'];
             $number = $ayat['nomor'];
             
             $ayat = json_decode($ayat['unicode_tajwid']);
             //  =====================
             $arabicNum = '<span style="padding: 0 15px 0 15px; background-color:grey; border-radius: 10px; color: white; margin-right: 5px;" >'.Generic::latinToArabicNumerals($number).'</span>';
             ?>
            <div class="font-kitab style-ayah pt-5" style="direction: rtl">
            <?=$parser->parse($ayat).$arabicNum?>               
            <br>
            <hr>
        </div>
            <?php } ?>
            <?php endfor; ?>
                   

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



<?php // ================================================================ // ?>
<?php require_once('common/footer.php'); ?>
