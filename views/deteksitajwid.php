<?php require_once('common/header.php') ?>
<?php require_once('../vendor/autoload.php');
$parser = new AlQuranCloud\Tools\Parser\Tajweed();
$koneksi = koneksi2();

$ayat = null;
if (isset($_POST['deteksi'])) {
    $ayat = $_POST['ayat'];
    $ayat = qolqolah($ayat);
    $ayat = madLazimMusy($ayat);
    $ayat = madLazimHarfi($ayat);
    $ayat = alifLamSyamsiah($ayat);
    $ayat = ghunnah($ayat);
    $ayat = iqlab($ayat);
}
 ?>

<!-- content -->
<div class="container-fluid pt-5">
    <main class="container mt-5 mb-5 py-3 px-5 border">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Deteksi Tajwid</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row justify-content-center">
                    <form action="" class="col-7 d-flex" method="post">
                        <input class="form-control" type="text" name="ayat" id="">
                        <button class="btn btn-success ms-2" type="submit" name="deteksi">Deteksi</button>
                    </form>
                </div>
            </div>
        </div>
        <?php if ($ayat == !null) : ?>
            <div class="row">
                <div class="col-12 ">
                    <div class="d-flex align-items-center justify-content-center" style="direction: rtl;">
                        <span class=" font-kitab style-ayah mt-3" style="direction: rtl;  font-size: 200%;">
                            <?php echo ($parser->parse($ayat)) ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <div class="col-12 ">
                    <div class="d-flex align-items-center justify-content-center" style="direction: rtl;">
                        <span class="  mt-3 ">
                            <h1 class="" style="direction: rtl;  font-size: 200%;"> Silahkan copy ayat didalam form </h1>
                        </span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>
